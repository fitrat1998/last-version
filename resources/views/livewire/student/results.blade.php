<div class="card mb-2">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fan">Fanlar </label>
                    <label>
                        <select class="select2 m-3 p-3 form-control">
                            <option selected>-- Tanlang --</option>

                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}">{{ $s->subject_name }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card p-1">
    <table id="example" class="table table-striped table-responsive" style="width:100%">
        <thead>
        <tr>
            <th>Fan</th>
            <th>Test turi</th>
            <th>Ball</th>
            <th>Sanasi</th>
            <th>Holati</th>
        </tr>
        </thead>
        <tbody>
            @foreach($results as $r)
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
