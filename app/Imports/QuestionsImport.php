<?php

namespace App\Imports;

use App\Models\options;
use App\Models\questions;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */

    protected $quizId;

    public function __construct($quizId)
    {
        $this->quizId = $quizId;
    }


    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // dd($row, $this->quizId);

            // Question::create([
            //     'question' => $row['question'],
            //     'option_1' => $row['option_1'],
            //     'option_2' => $row['option_2'],
            //     'option_3' => $row['option_3'],
            //     'option_4' => $row['option_4'],
            //     'correct_answer' => $row['answer'],
            // ]);
            $question = questions::create([
                "quiz_id" => $this->quizId,
                "question_text" => $row['question'],
            ]);

            $options = ['a', 'b', 'c', 'd'];
            // dd($question, $request->options);
            foreach ($options as $key => $value) {
                options::create([
                    "question_id" => $question->id,
                    "option_text" => strtoupper($value),
                    "option_value" => $row[$value],
                    "is_correct" => strtoupper($value) == strtoupper($row['correct']) ? 1 : 0,
                ]);
            }
        }
    }
}
