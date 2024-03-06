    <?php

    use App\Http\Controllers\Blade\HomeController;
    use App\Http\Controllers\Blade\PermissionController;
    use App\Http\Controllers\Blade\RoleController;
    use App\Http\Controllers\Blade\UserController;
    use App\Http\Controllers\EducationtypeController;
    use App\Http\Controllers\EducationyearController;
    use App\Http\Controllers\FacultyController;
    use App\Http\Controllers\FormofeducationController;
    use App\Http\Controllers\GroupController;
    use App\Http\Controllers\ProgrammController;
    use App\Http\Controllers\ResultController;
    use App\Http\Controllers\QuestionsController;
    use App\Http\Controllers\SemesterController;
    use App\Http\Controllers\Student\ExamController;
    use App\Http\Controllers\Student\MainController;
    use App\Http\Controllers\StudentController;
    use App\Http\Controllers\SubjectController;
    use App\Http\Controllers\FinalexamController;
    use App\Http\Controllers\AttendanceCheckController;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;


    Auth::routes();

    // Welcome page
    Route::get('/', function () {
        return redirect()->route('home');
    })->name('welcome');


    // Web pages
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        Route::get('student/public/', [MainController::class, 'index'])->name('studentAdminIndex');
        Route::get('student/public/subjects', [MainController::class, 'subjects'])->name('studentAdminSubjects');
        Route::get('student/public/subject/{id}', [MainController::class, 'SubjectsId'])->name('studentAdminSubjectsId');
        Route::get('student/public/self-study', [MainController::class, 'selfstudy'])->name('studentAdminSelfstudy');
        Route::get('student/public/middle-exam', [MainController::class, 'middleexam'])->name('studentAdminMiddleexam');
        Route::get('student/public/retry', [MainController::class, 'retry'])->name('studentAdminRetry');
        Route::get('student/public/finalexam', [MainController::class, 'finalexam'])->name('studentAdminFinal');
        Route::get('student/public/currentexam', [MainController::class, 'currentexam'])->name('studentAdminCurrent');
        Route::get('student/public/result', [MainController::class, 'result'])->name('studentAdminResult');
        Route::get('student/public/profile', [MainController::class, 'profile'])->name('StudentProfile');
        Route::get('student/public/exams/{type_id}/{id}', [ExamController::class, 'exams'])->name('StudentExams');
        Route::get('student/public/exams/solution/{type_id}/{id}', [ExamController::class, 'examsSolution'])->name('examsSolution');

        Route::get('student/public/exams/self/solution/{type_id}/{id}', [ExamController::class, 'examsSolutionSelfTest'])->name('examsSelfSolution');
        Route::get('student/public/exams/self/solution/{type_id}/{id}/result', [ResultController::class, 'examsSolutionSelfTestResult'])->name('examsSolutionSelfTestResult');

        Route::post('student/public/exams/status/{type_id}/{id}', [ExamController::class, 'status'])->name('StudentExamsStatus');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('userIndex');
        Route::get('/user/add', [UserController::class, 'add'])->name('userAdd');
        Route::post('/user/create', [UserController::class, 'create'])->name('userCreate');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('userEdit');
        Route::post('/user/update/{id}', [UserController::class, 'update'])->name('userUpdate');
        Route::delete('/user/delete/{id}', [UserController::class, 'destroy'])->name('userDestroy');
        Route::get('/user/theme-set/{id}', [UserController::class, 'setTheme'])->name('userSetTheme');

        // Permissions
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissionIndex');
        Route::get('/permission/add', [PermissionController::class, 'add'])->name('permissionAdd');
        Route::post('/permission/create', [PermissionController::class, 'create'])->name('permissionCreate');
        Route::get('/permission/{id}/edit', [PermissionController::class, 'edit'])->name('permissionEdit');
        Route::post('/permission/update/{id}', [PermissionController::class, 'update'])->name('permissionUpdate');
        Route::delete('/permission/delete/{id}', [PermissionController::class, 'destroy'])->name('permissionDestroy');

        // Roles
        Route::get('/roles', [RoleController::class, 'index'])->name('roleIndex');
        Route::get('/role/add', [RoleController::class, 'add'])->name('roleAdd');
        Route::post('/role/create', [RoleController::class, 'create'])->name('roleCreate');
        Route::get('/role/{role_id}/edit', [RoleController::class, 'edit'])->name('roleEdit');
        Route::post('/role/update/{role_id}', [RoleController::class, 'update'])->name('roleUpdate');
        Route::delete('/role/delete/{id}', [RoleController::class, 'destroy'])->name('roleDestroy');

        // Groups
        Route::get('/group', [GroupController::class, 'index'])->name('groupIndex');
        Route::get('/group/add', [GroupController::class, 'add'])->name('groupAdd');
        Route::post('/group/create', [GroupController::class, 'create'])->name('groupCreate');
        Route::get('/group/{group_id}/edit', [GroupController::class, 'edit'])->name('groupEdit');
        Route::get('/group/show/', [GroupController::class, 'show'])->name('groupShow');
        Route::get('/group/view/', [GroupController::class, 'show2'])->name('groupShow2');
        Route::post('/group/update/{group_id}', [GroupController::class, 'update'])->name('groupUpdate');
        Route::delete('/group/delete/{id}', [GroupController::class, 'destroy'])->name('groupDestroy');
        Route::post('/group/deleteAll', [GroupController::class, 'deleteAll'])->name('groupDeleteAll');


        // Faculties
        Route::get('/faculty', [FacultyController::class, 'index'])->name('facultyIndex');
        Route::get('/faculty/add', [FacultyController::class, 'add'])->name('facultyAdd');
        Route::post('/faculty/create', [FacultyController::class, 'create'])->name('facultyCreate');
        Route::get('/faculty/{faculty_id}/edit', [FacultyController::class, 'edit'])->name('facultyEdit');
        Route::get('/faculty/show/', [FacultyController::class, 'show'])->name('facultyShow');
        Route::post('/faculty/update/{faculty_id}', [FacultyController::class, 'update'])->name('facultyUpdate');
        Route::delete('/faculty/delete/{id}', [FacultyController::class, 'destroy'])->name('facultyDestroy');
        Route::post('/faculty/deleteAll', [FacultyController::class, 'deleteAll'])->name('facultyDeleteAll');

        // Programms
        Route::get('/programm', [ProgrammController::class, 'index'])->name('programmIndex');
        Route::get('/programm/add', [ProgrammController::class, 'add'])->name('programmAdd');
        Route::post('/programm/create', [ProgrammController::class, 'create'])->name('programmCreate');
        Route::get('/programm/{programm_id}/edit', [ProgrammController::class, 'edit'])->name('programmEdit');
        Route::get('/programm/show/', [ProgrammController::class, 'show'])->name('programmShow');
        Route::post('/programm/update/{programm_id}', [ProgrammController::class, 'update'])->name('programmUpdate');
        Route::delete('/programm/delete/{id}', [ProgrammController::class, 'destroy'])->name('programmDestroy');
        Route::post('/programm/deleteAll', [ProgrammController::class, 'deleteAll'])->name('programmDeleteAll');
        // Form of education
        Route::get('/formofeducation', [FormofeducationController::class, 'index'])->name('formofeducationIndex');
        Route::get('/formofeducation/add', [FormofeducationController::class, 'add'])->name('formofeducationAdd');
        Route::post('/formofeducation/create', [FormofeducationController::class, 'create'])->name('formofeducationCreate');
        Route::get('/formofeducation/{formofeducation_id}/edit', [FormofeducationController::class, 'edit'])->name('formofeducationEdit');
        Route::post('/formofeducation/update/{formofeducation_id}', [FormofeducationController::class, 'update'])->name('formofeducationUpdate');
        Route::delete('/formofeducation/delete/{id}', [FormofeducationController::class, 'destroy'])->name('formofeducationDestroy');
        Route::post('/formofeducation/deleteAll', [FormofeducationController::class, 'deleteAll'])->name('formofeducationDeleteAll');

        // Education years
        Route::get('/educationyear', [EducationyearController::class, 'index'])->name('educationyearIndex');
        Route::get('/educationyear/add', [EducationyearController::class, 'add'])->name('educationyearAdd');
        Route::post('/educationyear/create', [EducationyearController::class, 'create'])->name('educationyearCreate');
        Route::get('/educationyear/{educationyear_id}/edit', [EducationyearController::class, 'edit'])->name('educationyearEdit');
        Route::get('/educationyear/show/', [EducationyearController::class, 'show'])->name('educationyearShow');
        Route::post('/educationyear/update/{educationyear_id}', [EducationyearController::class, 'update'])->name('educationyearUpdate');
        Route::delete('/educationyear/delete/{id}', [EducationyearController::class, 'destroy'])->name('educationyearDestroy');
        Route::post('/educationyear/deleteAll', [EducationyearController::class, 'deleteAll'])->name('educationyearDeleteAll');


        // Education types
        Route::get('/educationtype', [EducationtypeController::class, 'index'])->name('educationtypeIndex');
        Route::get('/educationtype/add', [EducationtypeController::class, 'add'])->name('educationtypeAdd');
        Route::post('/educationtype/create', [EducationtypeController::class, 'create'])->name('educationtypeCreate');
        Route::get('/educationtype/{educationtype_id}/edit', [EducationtypeController::class, 'edit'])->name('educationtypeEdit');
        Route::post('/educationtype/update/{educationtype_id}', [EducationtypeController::class, 'update'])->name('educationtypeUpdate');
        Route::delete('/educationtype/delete/{id}', [EducationtypeController::class, 'destroy'])->name('educationtypeDestroy');
        Route::post('/educationtype/deleteAll', [EducationtypeController::class, 'deleteAll'])->name('educationtypeDeleteAll');

        // Semester
        Route::get('/semester', [SemesterController::class, 'index'])->name('semesterIndex');
        Route::get('/semester/add', [SemesterController::class, 'add'])->name('semesterAdd');
        Route::post('/semester/create', [SemesterController::class, 'create'])->name('semesterCreate');
        Route::get('/semester/{semester_id}/edit', [SemesterController::class, 'edit'])->name('semesterEdit');
        Route::post('/semester/update/{semester_id}', [SemesterController::class, 'update'])->name('semesterUpdate');
        Route::delete('/semester/delete/{id}', [SemesterController::class, 'destroy'])->name('semesterDestroy');
        Route::post('/semester/deleteAll', [SemesterController::class, 'deleteAll'])->name('semesterDeleteAll');

        // Subjects
        Route::get('/subject', [SubjectController::class, 'index'])->name('subjectIndex');
        Route::get('/subject/add', [SubjectController::class, 'add'])->name('subjectAdd');
        Route::post('/subject/create', [SubjectController::class, 'create'])->name('subjectCreate');
        Route::get('/subject/{subject_id}/edit', [SubjectController::class, 'edit'])->name('subjectEdit');
        Route::get('/subject/show/', [SubjectController::class, 'show'])->name('subjectShow');
        Route::get('/subject/show2/', [SubjectController::class, 'show2'])->name('subjectShow2');
        Route::post('/subject/update/{subject_id}', [SubjectController::class, 'update'])->name('subjectUpdate');
        Route::delete('/subject/delete/{id}', [SubjectController::class, 'destroy'])->name('subjectDestroy');
        Route::post('/subject/deleteAll', [SubjectController::class, 'deleteAll'])->name('subjectDeleteAll');

        // Students
        Route::get('/student', [StudentController::class, 'index'])->name('studentIndex');
        Route::get('/student/add', [StudentController::class, 'add'])->name('studentAdd');
        Route::post('/student/create', [StudentController::class, 'create'])->name('studentCreate');
        Route::post('/student/import', [StudentController::class, 'import'])->name('studentImport');
        Route::get('/student/{student_id}/edit', [StudentController::class, 'edit'])->name('studentEdit');
        Route::post('/student/update/{student_id}', [StudentController::class, 'update'])->name('studentUpdate');
        Route::delete('/student/delete/{id}', [StudentController::class, 'destroy'])->name('studentDestroy');
        Route::post('/student/deleteAll/{ids}', [StudentController::class, 'deleteAll'])->name('studentDeleteAll');


        //Attachstudent
        Route::resource('attachstudents', 'AttachstudentController');

        //Attachstudent
        Route::resource('attachteachers', 'AttachTeacherController');

        //Topics
        Route::resource('topics', 'TopicController');
        Route::delete('/deleteAllTopic', 'TopicController@deleteAll')->name('topics.DeleteAll');

        //Questions
        Route::resource('questions', 'QuestionsController');
        Route::post('/deleteAllQuestion', 'QuestionsController@deleteAll')->name('questions.DeleteAll');
        Route::post('questions/import', 'QuestionsController@import')->name('questions.import');

        //Lessons
        Route::resource('lessontypes', 'LessontypeController');
        Route::post('/deleteAllLessontype', 'LessontypeController@deleteAll')->name('lessontypes.DeleteAll');

        //Teachers
        Route::resource('teachers', 'TeacherController');
        Route::post('/deleteAllTeacher', 'TeacherController@deleteAll')->name('teachers.DeleteAll');
        Route::post('teachers/import', 'TeacherController@import')->name('teachers.import');


        //Attendance_logs
        Route::resource('attendance_logs', 'AttendanceLogController');
        Route::post('/deleteAllAttendanceLog', 'AttendanceLogController@deleteAll')->name('attendance_logs.DeleteAll');
        Route::get('/attendance-results', 'AttendanceLogController@results')->name('attendance_logs.attendance-results');


        //Attachstudent
        Route::resource('lessons', 'LessonController');
        Route::post('/deleteAllLesson', 'LessonController@deleteAll')->name('lessons.DeleteAll');

        //Test type
        Route::resource('examtypes', 'ExamtypeController');
        Route::get('/show2', 'ExamtypeController@show2')->name('examtypes.show2');
        Route::post('/deleteAllExamtype', 'ExamtypeController@deleteAll')->name('examtypes.DeleteAll');


        //Attendance check
        Route::resource('attendancechecks', 'AttendanceCheckController');
        Route::post('/deleteAllAttendanceCheck', 'AttendanceCheckController@deleteAll')->name('attendancechecks.DeleteAll');

        //Exercises
        Route::resource('exercises', 'ExerciseController');
        Route::post('/deleteAllExercise', 'ExerciseController@deleteAll')->name('exercises.DeleteAll');

        //MiddleExam
        Route::resource('middleexams', 'MiddleexamController');
        Route::post('/deleteAllMiddleexam', 'MiddleexamController@deleteAll')->name('middleexams.DeleteAll');

        //SelfstudyExam
        Route::resource('selfstudyexams', 'SelfstudyexamsController');
        Route::post('/deleteAllSelfstudyexams', 'SelfstudyexamsController@deleteAll')->name('selfstudyexams.DeleteAll');

        //RetryExam
        Route::resource('retriesexams', 'RetriesexamController');
        Route::post('/deleteAllRetriesexam', 'RetriesexamController@deleteAll')->name('retriesexams.DeleteAll');


        Route::resource('finalexams', 'FinalexamController');
        Route::post('/deleteAllFinalexam', 'FinalexamController@deleteAll')->name('finalexams.DeleteAll');


        Route::resource('currentexams', 'CurrentexamController');
        Route::post('/deleteAllCurrentexam', 'CurrentexamController@deleteAll')->name('currentexams.DeleteAll');


        Route::resource('announcements', 'AnnouncementController');
        Route::post('/deleteAllAnnouncement', 'AnnouncementController@deleteAll')->name('announcements.DeleteAll');

        Route::resource('results', 'ResultController');
        Route::post('results/data', 'ResultController@data')->name('teachersData');
        Route::get('results/getDataExam', 'ResultController@getDataExam')->name('results.getDataExam');






    });

    // Change language session condition
    Route::get('/language/{lang}', function ($lang) {
        $lang = strtolower($lang);
        if ($lang == 'ru' || $lang == 'uz') {
            session([
                'locale' => $lang
            ]);
        }
        return redirect()->back();
    });
