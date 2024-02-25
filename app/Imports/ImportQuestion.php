<?php

namespace App\Imports;

use App\Models\Options;
use App\Models\Question;
use App\Models\Topic;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportQuestion implements WithHeadingRow, ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

            $topicName = trim($row['mavzu']);
            $questionText = trim($row['savol']);
            $optionText = trim($row['variant']);
            $isCorrect = trim($row['javob']);
            $difficulty = trim($row['qiyinchilik']);

            $topic = Topic::where('topic_name', $topicName)->first();

            if (!$topic) {
                continue;
            }

            $existingQuestion = Question::where('question', $questionText)->first();

            if (!$existingQuestion) {
                $question = Question::create([
                    'topic_id' => $topic->id,
                    'question' => $questionText,
                ]);
            }

            $option = Options::create([
                'question_id' => $question->id,
                'option' => $optionText,
                'is_correct' => $isCorrect,
                'difficulty' => $difficulty, 
            ]);
        }
    }


}


