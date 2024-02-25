@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Savol tahrirlash</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('global.home')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('userIndex') }}">Tahrirlash</a></li>
                        <li class="breadcrumb-item active">@lang('global.edit')</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

    <section class="content">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('global.edit')</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <form action="{{ route('questions.update',$question->id)  }}" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label>Mavzu</label><br />
                                <select class="form-control select2" name="topic_id" id="topic_id">
                                    @foreach($topics as $topic)
                                    <option value = "{{ $topic->id }}" {{ ($topic->id == $question->topic_id ? "selected":'') }}>
                                        {{ $topic->topic_name }}
                                    </option>
                                    @endforeach
                                </select>

                            </div>

                             <div class="form-group">
                                <label>Savol</label>
                                 <input type="text" name="question" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('question',$question->question) }}" required>
                                @if($errors->has('question'))
                                    <span class="error invalid-feedback">{{ $errors->first('question') }}</span>
                                @endif
                            </div>
                            @php
                                $i = 0;
                                $v = ['A','B','C','D','E','F','G'];
                            @endphp
                               <label >Variantlar</label><br/>
                            @foreach ($options as $option)
                                @php
                                    $i++;
                                @endphp
                                <div class="input-group p-3">
                                    <label for="checkBox{{$option->id}}"> {{ $v[$i-1] }}</label><br/>
                                    <input style="width:5%" id="checkBox{{$option->id}}" type="checkbox" value="{{ $option->is_correct }}" class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}"  {{ ($option && $option->is_correct == 1) ? 'checked' : '' }} disabled>
                                    <input style="width:5%" id="checkBox{{$option->id}}" type="checkbox" value="{{ $option->is_correct }}" name="status.{{$option->id}}" class="form-control {{ $errors->has('status') ? ' is-invalid' : '' }}" {{ ($option && $option->is_correct == 1) ? 'checked' : '' }}>
                                    <input style="width:70% "  type="text" name="option[]" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('option',$option->option) }}" required/>
                                    <input style="width:70% "  type="hidden" name="option_id[]" class="form-control {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('option_id',$option->id) }}" required/>
                                    <input style="width:7% " type="numeric" name="difficulty[]" class="form-control ml-1  {{ $errors->has('name') ? "is-invalid":"" }}" value="{{ old('difficulty',$option->difficulty) }}" required />
                                </div>
                            @endforeach
                            @if($errors->has('question'))
                                <span class="error invalid-feedback">{{ $errors->first('question') }}</span>
                            @endif
                            <div class="form-group">
                                <button type="submit" class="btn btn-success float-right">Saqlash</button>
                                <a href="{{ route('groupIndex') }}" class="btn btn-default float-left">Bekor qilish</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


<script>
    function changeValue() {
        var checkbox = document.getElementById("myCheckbox");
        var value = checkbox.checked ? 0 : 1;
        // Değerle yapmak istediğiniz şeyi burada yapabilirsiniz
        console.log("Value:", value);
    }
</script>
