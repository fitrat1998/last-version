@extends('layouts.student-app')
@section('content')
    @if ($examp->status(auth()->user()->id))
        <div class="alert alert-success">
            <h6 class="text-dark">Siz Oraliqda ishtirok etmoqdasiz</h6>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Holati</th>
            <td>
                <div class="text-info">
                    @if($examp->TimeStatus($examp->start,$examp->end))
                        Boshlangan
                    @else
                        Boshlanmagan
                    @endif
                </div>
            </td>
        </tr>

        <tr>
            <th>Turi:</th>
            <td>
                <div style="text-transform: uppercase;">{{ $examp->examtype->name ?? "Mavjud emas" }}</div>
            </td>
        </tr>

        <tr>
            <th>Fan:</th>
            <td>
                <div style="text-transform: uppercase;">{{ $examp->subject->subject_name ?? "Mavjud emas" }}</div>
            </td>
        </tr>

        <tr>
            <th>Guruh</th>
            <td>{{ $examp->group->name ?? "Mavjud emas" }}</td>
        </tr>

        <tr>
            <th>Semestr</th>
            <td>{{ $examp->semester->semester_number ?? "Mavjud emas" }}</td>
        </tr>
        <tr>
            <th>Eng katta ball / To'g'ri javoblar</th>

            @if($maxBall)
                <td class="text-success"><b>{{ $maxBall }} / {{ $maxCorrect }}</b>
                </td>
            @elseif(( $maxBall > $examp->passing))
                <td class="text-danger"><b>{{ $maxBall }} / {{ $maxCorrect }} </b></td>
            @else
                <td class="">0</td>
            @endif

        </tr>
        <tr>
            <th width="300px">Boshlanish vaqti</th>
            <td>{{ $examp->start }}</td>
        </tr>

        <tr>
            <th>Tugash vaqti</th>
            <td>{{ $examp->end }}</td>
        </tr>

        <tr>
            <th>Davomiyligi:</th>
            <td>
                <div>{{ $vaqt }}</div>
            </td>
        </tr>

        <tr>
            <th>Urinishlar:</th>
            <td>
                <div>
                    {{ $results }} / {{ $examp->attempts ?? "0" }}
                </div>
            </td>
        </tr>
        <tr>
            <th>Testlar soni:</th>
            <td>{{ $examp->number }}</td>
        </tr>
    </table>
    @if($examp->TimeStatus($examp->start,$examp->end))
        <a href="{{ route('examsSolution',['type_id' => $examp->examtypes_id, 'id' => $examp->id]) }}"
           class="btn btn-success">
            Savollarni ko'rish
        </a>
    @elseif($examp->status(auth()->user()->id))
        <form method="post"
              action="{{ route('StudentExamsStatus',['type_id' => $examp->examtypes_id, 'id' => $examp->id]) }}">
            @csrf
            <button type="submit" class="btn btn-danger"> Arizani bekor qilish</button>
        </form>
    @else
        <form method="post"
              action="{{ route('StudentExamsStatus',['type_id' => $examp->examtypes_id, 'id' => $examp->id]) }}">
            @csrf
            <button type="submit" class="btn btn-info"> Qatnashish</button>
        </form>
    @endif
@endsection
