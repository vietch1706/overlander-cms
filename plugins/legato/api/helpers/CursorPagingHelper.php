<?php

namespace Legato\Api\Helpers;

use Illuminate\Support\Facades\Config;
use October\Rain\Database\Builder;
use October\Rain\Support\Facades\Input;

class CursorPagingHelper {
    private const IS_NEXT_KEY = 'N';
    private const IS_PREVIOUS_KEY = 'P';
    private const CURSOR_SEPARATOR = '&';
    private const CURSOR_KEY_SEPARATOR = '=';

    public static function paginate(
        Builder $query,
        string $modelTable,
        array $cursorKeys
    ): array {
        $paging = self::getCursorPagingParams();

        $cursorFields = [];
        if (!empty($paging['cursor']['params'])) {
            foreach ($paging['cursor']['params'] as $key => $value) {
                $cursorFields[$key] = $value;
            }
        }

        $rows = self::search(
            $query,
            $modelTable,
            $cursorKeys,
            $cursorFields,
            empty($paging['cursor']['isPrev']),
            $paging['limit']
        );

        $itemsCount = $rows->count();
        $cursor = [
            'previous' => null,
            'next' => null,
            'limit' => $paging['limit'],
            'itemsCount' => $itemsCount,
        ];
        if ($itemsCount) {
            $last = $rows->last();
            $params = [];
            foreach ($cursorKeys as $cursorKey) {
                $params[$cursorKey] = $last->{$cursorKey};
            }
            $cursor['next'] = self::makeCursorPagingParams($params);

            $first = $rows->first();
            $params = [];
            foreach ($cursorKeys as $cursorKey) {
                $params[$cursorKey] = $first->{$cursorKey};
            }
            $cursor['previous'] = self::makeCursorPagingParams($params, false);
        }

        return [
            'cursor' => $cursor,
            'items' => $itemsCount ? $rows : null,
        ];
    }

    private static function search(
        $query,
        string $modelTable,
        array $cursorKeys,
        array $cursorFields,
        bool $isNext,
        int $limit
    ) {
        $operator = '<';
        $orderBy = 'DESC';
        if (!$isNext) {
            $operator = '>';
            $orderBy = 'ASC';
        }

        if (count($cursorFields)) {
            $query->where(static function ($query) use ($modelTable, $operator, $cursorFields) {
                $firstKey = array_key_first($cursorFields);
                $firstValue = array_shift($cursorFields);
                $query->where("$modelTable.$firstKey", $operator, $firstValue);

                if (count($cursorFields)) {
                    self::buildSearchQuery($query, $modelTable, $operator, $firstKey, $firstValue, $cursorFields);
                }
            });
        }

        foreach ($cursorKeys as $cursorKey) {
            $query->orderBy("$modelTable.$cursorKey", $orderBy);
        }

        $query->limit($limit);

        $collection = $query->get();

        if ($collection && $orderBy === 'ASC') {
            $cursorKeys = array_keys($cursorFields);
            $collection = $collection->sort(function ($prev, $next) use ($cursorKeys) {
                foreach ($cursorKeys as $cursorKey) {
                    if ($prev->{$cursorKey} > $next->{$cursorKey}) {
                        return -1;
                    }
                    if ($prev->{$cursorKey} < $next->{$cursorKey}) {
                        return 1;
                    }
                }

                return 0;
            });
        }

        return $collection;
    }

    private static function buildSearchQuery(
        $query,
        string $modelTable,
        string $operator,
        string $firstKey,
        $firstValue,
        array $cursorFields
    ): void {
        $query->orWhere(static function ($query) use ($modelTable, $operator, $firstKey, $firstValue, $cursorFields) {
            $query->where("$modelTable.$firstKey", '=', $firstValue);

            $firstKey = array_key_first($cursorFields);
            $firstValue = array_shift($cursorFields);
            $query->where("$modelTable.$firstKey", $operator, $firstValue);

            if (count($cursorFields)) {
                self::buildSearchQuery($query, $modelTable, $operator, $firstKey, $firstValue, $cursorFields);
            }
        });
    }

    private static function getCursorPagingParams(): array
    {
        $input = Input::all();

        $limit = !empty($input['limit']) ? (int)$input['limit'] : Config::get('legato.api::paginate_records_per_page', 30);
        $limit = min($limit, Config::get('legato.api::paginate_records_max_limit', 100));

        return [
            'cursor' => self::parseCursorPagingParams(!empty($input['cursor']) ? $input['cursor'] : ''),
            'limit' => $limit,
        ];
    }

    private static function makeCursorPagingParams(array $params, bool $isNext = true): string
    {
        array_unshift($params, $isNext ? self::IS_NEXT_KEY : self::IS_PREVIOUS_KEY);

        return self::encodeCursor($params);
    }

    private static function parseCursorPagingParams(string $cursor = null): array
    {
        $output = [
            'isPrev' => false,
            'params' => [],
        ];

        $params = $cursor ? self::decodeCursor($cursor) : [];
        if ($params && !empty($params[0])) {
            $output['isPrev'] = $params[0][1] === self::IS_PREVIOUS_KEY;
            array_shift($params);
            if ($params) {
                foreach ($params as $param) {
                    $output['params'][$param[0]] = $param[1];
                }
            }
        }

        return $output;
    }

    private static function decodeCursor(string $cursor): array
    {
        $params = explode(self::CURSOR_SEPARATOR, base64_decode($cursor));

        return array_map(static function ($item){
            return explode(self::CURSOR_KEY_SEPARATOR, $item);
        }, $params);
    }

    private static function encodeCursor(array $cursors): string
    {
        $params = [];
        foreach ($cursors as $key => $value) {
            $params[] = $key . self::CURSOR_KEY_SEPARATOR . $value;
        }

        return base64_encode(implode(self::CURSOR_SEPARATOR, $params));
    }
}
