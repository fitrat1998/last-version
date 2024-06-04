<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendancecheck;
use App\Models\Currentexam;
use App\Models\ExamsStatusUser;
use App\Models\Finalexam;
use App\Models\Middleexam;
use App\Models\Options;
use App\Models\Question;
use App\Models\Result;
use App\Models\Retriesexam;
use App\Models\Selfstudyexams;
use App\Models\Topic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use function view;

class ExamController extends Controller
{
    public function exams($type_id, $id)
    {
        if ($type_id == 1) {
            $examp = Middleexam::find($id);
        } else if ($type_id == 2) {
            $examp = Selfstudyexams::find($id);
        } else if ($type_id == 3) {
            $examp = Retriesexam::find($id);
        } else if ($type_id == 4) {
            $examp = Finalexam::find($id);
        } else if ($type_id == 5) {
            $examp = Currentexam::find($id);
        }

        if ($examp) {
            $start = Carbon::createFromFormat('Y-m-d H:i:s', $examp->start);

            $end = Carbon::createFromFormat('Y-m-d H:i:s', $examp->end);
            $vaqt = $start->diffForHumans($end);
            $ud = auth()->user()->id;
            $results = Result::where('examtypes_id', $type_id)
                ->where('quizzes_id', $id)
                ->where('users_id', auth()->user()->id)
                ->get();

            $results = count($results);

            $maxCorrect = Result::where('examtypes_id', $type_id)
                ->where('quizzes_id', $id)
                ->where('users_id', auth()->user()->id)
                ->pluck('correct')
                ->max();

            $results1 = Result::where('users_id', $ud)
                ->where('quizzes_id', $id)
                ->where('examtypes_id', $examp->examtypes_id)
                ->where('subjects_id', $examp->subjects_id)
                ->get();

            $maxBall = 0;

            foreach ($results1 as $result) {
                $maxBall = max($maxBall, floatval($result->ball));
            }

            $result = Result::find($type_id);
            return view('students.testing.index', compact('examp', 'vaqt', 'results', 'maxBall', 'maxCorrect', 'result'));
        } else {
            return redirect()->back()->with('error', "Kirish ruxsati berilmagan");
        }
    }

    public function status($examtype_id, $id)
    {

        $uid = auth()->user()->id;
        $examp = ExamsStatusUser::where('user_id', $uid)->get();

        if ($examtype_id == 1) {
            $exams = Middleexam::find($id);
        } else if ($examtype_id == 2) {
            $exams = Selfstudyexams::find($id);
        } else if ($examtype_id == 3) {
            $exams = Retriesexam::find($id);
        } else if ($examtype_id == 4) {
            $exams = Finalexam::find($id);
        } else if ($examtype_id == 5) {
            $exams = Currentexam::find($id);
        }


        if (count($examp) == 0) {
            ExamsStatusUser::create([
                'user_id' => $uid,
                'exams_id' => $id,
                'examtypes_id' => $exams->examtypes_id
            ]);
            return redirect()->back();
        } else {
            ExamsStatusUser::where('user_id', $id)->delete();
            return redirect()->back();
        }
    }

    public function examsSolution($type_id, $id)
    {
        if ($type_id == 1) {
            $data = Middleexam::find($id);
        } else if ($type_id == 2) {
            $data = Selfstudyexams::find($id);
        } else if ($type_id == 3) {
            $data = Retriesexam::find($id);
        } else if ($type_id == 4) {
            $data = Finalexam::find($id);
        } else if ($type_id == 5) {
            $data = Currentexam::find($id);
        }

        $c = Result::where('examtypes_id', $type_id)
            ->where('quizzes_id', $id)
            ->where('users_id', auth()->user()->id)
            ->get();

        if (isset($data->attempts)) {
            if ($data->attempts <= count($c)) {
                return redirect()->back()->with('error', "Kirishlar soni tugagan");
            } else {
                return view('students.testing.testing', compact('data'));
            }
        } else {
            return redirect()->back()->with('error', "Malumotlar yetarli emas");
        }
    }

    public function examsSolutionSelfTest($type_id, $id): \Illuminate\Http\JsonResponse
    {
        $self = null;

        if ($type_id == 1) {
            $self = Middleexam::find($id);


        } else if ($type_id == 2) {
            $self = Selfstudyexams::find($id);
        } else if ($type_id == 3) {
            $self = Retriesexam::find($id);
        } else if ($type_id == 4) {
            $self = Finalexam::find($id);
        } else if ($type_id == 5) {
            $self = Currentexam::find($id);
        }

        $u_id = auth()->user()->id;
        $s_id = User::find($u_id);

        $topic = Attendancecheck::where('students_id', $s_id->student_id)->pluck('topics_id');
        $subject = Attendancecheck::where('students_id', $s_id->student_id)->pluck('subjects_id');


        $number = $self->number;
        $test = [];
        $randomTestElements = [];
        if ($self) {
            $subjects_id = $self->subjects_id;

//            $topics = Topic::where('subject_id',$subjects_id)
//                ->pluck('id');

            if ($type_id == 3) {
                $topics = DB::table('exam_has_topic')
                    ->whereIn('subject_id', $subject)
                    ->where('examtypes_id', $type_id)
                    ->pluck('id');
            } else {
                $topics = DB::table('exam_has_topic')
                    ->where('exams_id','=', intval($self->id))
                    ->where('examtypes_id','=', intval($type_id))
                    ->pluck('topics_id');
            }

            $randomQuestion = Question::whereIn('topic_id', $topics)
                ->inRandomOrder()
                ->limit($number)
                ->get();

            $k = 0;
            foreach ($randomQuestion as $question) {
                $options = Options::where('question_id', $question->id)
                    ->where('is_correct', 1)
                    ->get();

                $condition = (count($options) >= 2);

                $options = Options::where('question_id', $question->id)
                    ->get();

                $k1 = 0;
                $varyand = [];

                foreach ($options as $o) {
                    $varyand[chr($k1 + 97)] = $o->option;
                    $k1++;
                }

                $test[] = [
                    'id' => $question->id,
                    'multipleSelect' => false,
                    'questionIndex' => $k + 1,
                    'question' => $question->question,
                    'variants' => $varyand
                ];

                $k++;
            }
        }

        return response()->json($test);
    }
}
