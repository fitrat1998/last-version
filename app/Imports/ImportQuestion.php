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
    public function options_create($arr)
    {
        for ($i=0;$i<count($arr);$i++) {
            for ($j=0;$j<count($arr[$i]["option"]);$j++) {
                Options::create([
                    'question_id'   => $arr[$i]["quetion"],
                    'option'        => $arr[$i]["option"][$j],
                    'is_correct'    => $arr[$i]["correct"][$j],
                    'difficulty'    => $arr[$i]["difficulty"][$j],
                ]);
            }
        }
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $options_map = [];
        for ($i=0;$i<count($rows);$i+=4) {
             $topicName = trim($rows[$i]['mavzu']);
             $questionText = trim($rows[$i]['savol']);
             $isCorrect = [];
             $difficulty = [];
             $option = [];

             for ($j=0;$j<4;$j++){
                 $option[] = $rows[$i+$j]['variant'];
                 $isCorrect[] =  $rows[$i+$j]['javob'];
                 $difficulty[] = $rows[$i+$j]['qiyinchilik'];
             }
             $topic = Topic::where('topic_name', $topicName)->first();

            if (!$topic) {
                continue;
            }

            $question = Question::where('question', $questionText)->first();

            if (!$question) {
                $question = Question::create([
                    'topic_id' => $topic->id,
                    'question' => $questionText,
                ]);
            }

            $options_map[] = ["quetion" => $question->id,"option" => $option,"correct" => $isCorrect,"difficulty" => $difficulty];
        }

        $this->options_create($options_map);

    }


}


