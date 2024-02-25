<div>
    <section class="content">
        <div class="container-fluid">
            <div class="row p-3">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form wire:submit.prevent="create">
                            <div class="card-body">
                                <div class="float-right m-1">
                                    <div>
                                        <input type="file" wire:model="excel" name="file">
                                        <button class="btn btn-success" wire:click="import">Savollar yuklash</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div>
                                        <label for="exampleInputEmail1">Mavzu tanlang</label>
                                        <select class="form-control select2" wire:model="topic_id" id="topic_id">
                                            <option value="">Mavzu tanlang</option>
                                            @foreach($topics as $topic)
                                                <option value="{{ $topic->id }}">{{ $topic->topic_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Savol matni</label>
                                    <textarea type="text" wire:model="question" class="form-control" id="summernote"
                                              rows="8" >Savol matnini kiriting</textarea>
                                </div>
                                @for ($i = 0; $i < $counter; $i++)
                                    <h5>Varyand {{ chr($i + 65) }}</h5>

                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <input id="chx" type="checkbox" wire:model="answer.{{ $i }}">
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" wire:model="variant.{{ $i }}"
                                                       required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input class="form-control" type="numeric" wire:model="difficulty.{{ $i }}" >

                                            </div>
                                        </div>
                                    </div>
                                @endfor
                                <button class="btn btn-primary mt-2" type="button" wire:click="countCreate"><i
                                        class="fa fa-plus"></i> Varyant qo'shish
                                </button>
                                <button class="btn btn-danger mt-2" type="button" wire:click="countTrash"><i
                                        class="fa fa-minus"></i> Variant ochirish
                                </button>
                                @if(session()->has('errors'))
                                    <div class="text-danger">{{ session('errors') }}</div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Qo'shish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
