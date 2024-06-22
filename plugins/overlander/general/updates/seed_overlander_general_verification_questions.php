<?php

namespace Overlander\General\Updates;

use Carbon\Carbon;
use Overlander\General\Models\VerificationQuestions;
use Seeder;

/**
 * SupportivePageSeeders
 */
class SeedOverlanderGeneralVerificationQuestions extends Seeder
{
    /**
     * run the database seeds.
     */
    public function run()
    {
        $questions = [
            [
                'name' => "When was year birth year and month?"
            ],
            [
                'name' => "What is your email address?"
            ],
            [
                'name' => "When did you join overlander membership?"
            ],
            [
                'name' => "	When was your last purchase?"
            ],
            [
                'name' => "When was year birth year and month?"
            ],
            [
                'name' => "What is your member no.?"
            ],
            [
                'name' => "What is the access code?"
            ], [
                'name' => "What is your phone no.?"
            ],

        ];
        foreach ($questions as $key => $value) {
            $question = new VerificationQuestions();
            $question->name = $value['name'];
            $question->created_at = Carbon::now();
            $question->updated_at = Carbon::now();
            $question->save();
        }
    }
}
