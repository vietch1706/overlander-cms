<?php

namespace Overlander\General\Repository;

use Backend\Facades\BackendAuth;
use Lang;
use Legato\Api\Exceptions\NotFoundException;
use Overlander\General\Helper\General;
use Overlander\General\Models\MembershipTier as MembershipTierModel;
use Overlander\Transaction\Models\PointHistory;
use function number_format;

class MembershipTier
{

    public MembershipTierModel $membershipTiers;

    public function __construct(MembershipTierModel $membershipTier)
    {
        $this->membershipTiers = $membershipTier;
    }

    public static function convertData($membership)
    {
        return [
            'id' => $membership->id,
            'name' => $membership->name,
            'logo' => General::getBaseUrl() . $membership->logo,
            'period' => $membership->period,
            'slug' => $membership->slug,
            'points_required' => number_format($membership->points_required),
        ];
    }

    public function getAll()
    {
        $list = $this->membershipTiers->where('group', MembershipTierModel::GROUP_AUTOMATIC)->get();
        $data = [];
        foreach ($list as $key => $value) {
            $data[] = $this->convertData($value);
        }
        if (empty($data)) {
            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
        }
        return $data;
    }

    public function getById($id)
    {
        $data = null;
        $list = $this->membershipTiers->getById($id)->first();
        if (!empty($list)) {
            $data = $this->convertData($list);
        } else {
            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
        }
        return $data;
    }
    public static function upgrade()
    {
        $user = BackendAuth::getUser();
        if ($user->membership_tier_id == MembershipTierModel::ID_GOLD) {
            throw new NotFoundException(Lang::get('overlander.general::lang.not_found'));
        }
        $amount = 0;
        $next = MembershipTierModel::select('id', 'name', 'slug', 'period', 'points_required')
            ->whereNot('id', $user->membership_tier_id)
            ->where('group', MembershipTierModel::GROUP_AUTOMATIC)
            ->where('id', '>', $user->membership_tier_id)
            ->orderBy('id', 'asc')
            ->first();
        if ($next->slug == MembershipTierModel::SLUG_GOLD) {
            $amount = $user->points_sum;
        }
        else {
            $amount = $next->points_required;
        }
        if ($user->points_sum > $next->points_required) {
            $user->membership_tier_id = $next->id;
            $user->points_sum -= $next->points_required;
            PointHistory::addPointHistory(
                $user->id,
                PointHistory::TYPE_LOSS,
                $amount,
                null,
                PointHistory::IS_USED_UNUSABLE,
                PointHistory::IS_HIDDEN_FALSE,
                Lang::get('overlander.transaction::lang.point_history.loss_reason.upgrade', ['membership'=> $next->name]),
                null,
            );
            PointHistory::updateHiddenPoint($amount, $user->id, $next->slug);
            $user->save();
        }
    }
}
