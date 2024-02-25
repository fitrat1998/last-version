<div
    class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition">
    <nav class="mt-2">
        <ul class="nav sidebar-toggle  nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview"
            role="menu"
            data-accordion="true">
            @canany(['permission.show', 'roles.show', 'user.show'])
                <li class="nav-item has-treeview ">
                    <a href="#"
                       class="nav-link {{ Request::is('permission*') || Request::is('role*') || Request::is('user*') ? 'active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        <p>
                            @lang('cruds.userManagement.title')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"
                        style="display: {{ Request::is('permission*') || Request::is('role*') || Request::is('user*') ? 'block' : 'none' }};">
                        @can('permission.show')
                            <li class="nav-item">
                                <a href="{{ route('permissionIndex') }}"
                                   class="nav-link {{ Request::is('permission*') ? 'active' : '' }}">
                                    <i class="fas fa-key"></i>
                                    <p> @lang('cruds.permission.title_singular')</p>
                                </a>
                            </li>
                        @endcan

                        @can('roles.show')
                            <li class="nav-item">
                                <a href="{{ route('roleIndex') }}"
                                   class="nav-link {{ Request::is('role*') ? 'active' : '' }}">
                                    <i class="fas fa-user-lock"></i>
                                    <p> @lang('cruds.role.fields.roles')</p>
                                </a>
                            </li>
                        @endcan

                        @can('user.show')
                            <li class="nav-item">
                                <a href="{{ route('userIndex') }}"
                                   class="nav-link {{ Request::is('user*') ? 'active' : '' }}">
                                    <i class="fas fa-user-friends"></i>
                                    <p> @lang('cruds.user.title')</p>
                                </a>
                            </li>
                        @endcan
                    </ul>

                </li>
            @endcanany

            <li class="nav-item has-treeview">
                    <a href="#"
                       class="nav-link {{ Request::is('faculty*') || Request::is('programm*') ||
                         Request::is('educationtype*') || Request::is('formofeducation*') || Request::is('educationyear*') ||
                         Request::is('semester*') ||  Request::is('lessontype*') || Request::is('semester*') || Request::is('group*')
                          ? 'active' : '' }}">
                        <i class="fa-solid fa-building"></i>
                        <p>
                            OTM Malumotlari
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"
                        style="display: {{  Request::is('faculty*') || Request::is('programm*') ||
                         Request::is('educationtype*') || Request::is('formofeducation*') || Request::is('educationyear*') ||
                         Request::is('semester*') ||  Request::is('lessontype*') || Request::is('semester*') || Request::is('group*') ? 'block' : 'none' }};">
                        @can('faculty.show')
                            <li class="nav-item">
                                <a href="{{ route('facultyIndex') }}"
                                   class="nav-link {{ Request::is('faculty*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-building-columns"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Fakultetlar</p>
                                </a>
                            </li>
                        @endcan
                        @can('programm.show')
                            <li class="nav-item">
                                <a href="{{ route('programmIndex') }}"
                                   class="nav-link {{ Request::is('programm*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-network-wired"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Yo'nalishlar</p>
                                </a>

                            </li>
                        @endcan
                        @can('educationtype.show')
                            <li class="nav-item">
                                <a href="{{ route('educationtypeIndex') }}"
                                   class="nav-link {{ Request::is('educationtype*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-book-open-reader"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Ta'lim turi</p>
                                </a>
                            </li>
                        @endcan
                        @can('formofeducation.show')
                            <li class="nav-item">
                                <a href="{{ route('formofeducationIndex') }}"
                                   class="nav-link {{ Request::is('formofeducation*') ? 'active' : '' }}">
                                    <i class="fas fa-shapes"></i>
                                    <p>Ta'lim shakli</p>
                                </a>
                            </li>
                        @endcan
                        @can('educationyear.show')
                            <li class="nav-item">
                                <a href="{{ route('educationyearIndex') }}"
                                   class="nav-link {{ Request::is('educationyear*') ? 'active' : '' }}">
                                    <i class="fa-regular fa-calendar-check"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>O'quv yili</p>
                                </a>
                            </li>
                        @endcan
                        @can('semester.show')
                            <li class="nav-item">
                                <a href="{{ route('semesterIndex') }}"
                                   class="nav-link {{ Request::is('semester*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-table"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Semestrlar</p>
                                </a>
                            </li>
                        @endcan
                        @can('lessontype.show')
                            <li class="nav-item">
                                <a href="{{ route('lessontypes.index') }}"
                                   class="nav-link {{ Request::is('lessontype*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-table"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Darslar turi</p>
                                </a>
                            </li>
                        @endcan
                        @can('group.show')
                            <li class="nav-item">
                                <a href="{{ route('groupIndex') }}"
                                   class="nav-link {{ Request::is('group*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-user-group"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Guruhlar</p>
                                </a>

                            </li>
                        @endcan
                    </ul>
                </li>


            <li class="nav-item has-treeview">
                    <a href="#"
                       class="nav-link {{ Request::is('subject*')  || Request::is('topic*') || Request::is('question*') ||
                        Request::is('examtype*') || Request::is('middleexam*') || Request::is('finalexam*') || Request::is('announcement*')
                        || Request::is('currentexams*') ? 'active' : '' }}">
                        <i class="fa-solid fa-thumbtack"></i>
                        <p>
                            Topshiriq
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"
                        style="display: {{ Request::is('subject*') || Request::is('topic*') || Request::is('question*') || Request::is('examtype*') || Request::is('currentexam*') || Request::is('middleexam*')  || Request::is('selfstudyexam*') || Request::is('retriesexams*') || Request::is('finalexams*') || Request::is('announcements*')  ? 'block' : 'none' }};">

                        @can('subject.show')
                            <li class="nav-item">
                                <a href="{{ route('subjectIndex') }}"
                                   class="nav-link {{ Request::is('subject*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-bookmark"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Fanlar</p>
                                </a>

                            </li>
                        @endcan

                        @can('topic.show')
                            <li class="nav-item">
                                <a href="{{ route('topics.index') }}"
                                   class="nav-link {{ Request::is('topic*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-book"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Mavzular</p>
                                </a>

                            </li>
                        @endcan


                        @can('question.show')
                            <li class="nav-item">
                                <a href="{{ route('questions.index') }}"
                                   class="nav-link {{ Request::is('question*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-users"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Savollar</p>
                                </a>

                            </li>
                        @endcan

                        @can('examtype.show')
                            <li class="nav-item">
                                <a href="{{ route('examtypes.index') }}"
                                   class="nav-link {{ Request::is('examtype*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-layer-group"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Test turi</p>
                                </a>

                            </li>
                        @endcan

                        @can('currentexam.show')
                            <li class="nav-item">
                                <a href="{{ route('currentexams.index') }}"
                                   class="nav-link {{ Request::is('currentexams*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-add"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Joriy nazorat yaratish</p>
                                </a>

                            </li>
                        @endcan

                        @can('middleexam.show')
                            <li class="nav-item">
                                <a href="{{ route('middleexams.index') }}"
                                   class="nav-link {{ Request::is('middleexam*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-add"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Oraliq nazorat yaratish</p>
                                </a>

                            </li>
                        @endcan
                        @can('selfstudyexam.show')
                            <li class="nav-item">
                                <a href="{{ route('selfstudyexams.index') }}"
                                   class="nav-link {{ Request::is('selfstudy*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-add"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Mustaqil ish yaratish</p>
                                </a>

                            </li>
                        @endcan

                        @can('retryexam.show')
                            <li class="nav-item">
                                <a href="{{ route('retriesexams.index') }}"
                                   class="nav-link {{ Request::is('retriesexams*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-add"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Qayta topshirish yaratish</p>
                                </a>

                            </li>
                        @endcan

                        @can('finalexam.show')
                            <li class="nav-item">
                                <a href="{{ route('finalexams.index') }}"
                                   class="nav-link {{ Request::is('finalexams*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-add"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Yakuniy nazorat</p>
                                </a>

                            </li>
                        @endcan

                        @can('announcement.show')
                            <li class="nav-item">
                                <a href="{{ route('announcements.index') }}"
                                   class="nav-link {{ Request::is('announcements*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-bullhorn"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>E'lon</p>
                                </a>

                            </li>
                        @endcan

                    </ul>

                </li>


            <li class="nav-item has-treeview">
                <a href="#"
                   class="nav-link {{ Request::is('teachers*') ? 'active' : '' }}">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    <p>
                        O'qituvchilar
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview"
                    style="display: {{ Request::is('teachers*') || Request::is('role*') || Request::is('user*') ? 'block' : 'none' }};">

                    @can('teacher.show')
                        <li class="nav-item">
                            <a href="{{ route('teachers.index') }}"
                               class="nav-link {{ Request::is('teachers*') ? 'active' : '' }}">
                                <i class="fa-solid fa-user-group"></i>
                                <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                <p>O'qituvchilar</p>
                            </a>

                        </li>
                    @endcan

                    @can('teacherattach.show')
                        <li class="nav-item">
                            <a href="{{ route('attachteachers.index') }}"
                               class="nav-link {{ Request::is('attachteachers*') ? 'active' : '' }}">
                                <i class="fa-solid fa-user-group"></i>
                                <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                <p>Guruhga biriktirish</p>
                            </a>

                        </li>
                    @endcan


                </ul>

            </li>

            <li class="nav-item has-treeview">
                    <a href="#"
                       class="nav-link {{ (Request::is('attachstudents/create') || Request::is('student*')) ? 'active' : '' }}">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <p>
                            Talabalar
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"
                        style="display: {{ Request::is('attachstudents/create') || Request::is('student*') ? 'block' : 'none' }};">

                        @can('student.show')
                            <li class="nav-item">
                                <a href="{{ route('studentIndex') }}"
                                   class="nav-link {{ Request::is('student') ? 'active' : '' }}">
                                    <i class="fa-solid fa-users"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Talaba ko'rish</p>
                                </a>

                            </li>
                        @endcan

                        @can('student.show')
                            <li class="nav-item">
                                <a href="{{ route('studentAdd') }}"
                                   class="nav-link {{ Request::is('student/add') ? 'active' : '' }}">
                                    <i class="fa-solid fa-user-plus"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Talaba qo'shish</p>
                                </a>

                            </li>
                        @endcan
                        @can('studentattach.show')
                            <li class="nav-item">
                                <a href="{{ route('attachstudents.create') }}"
                                   class="nav-link {{ Request::is('attachstudents/create') ? 'active' : '' }}">
                                    <i class="fa-solid fa-user-plus"></i>
                                    <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                    <p>Talaba biriktirish</p>
                                </a>

                            </li>
                        @endcan

                    </ul>

                </li>

            <li class="nav-item has-treeview">
                <a href="#"
                   class="nav-link {{ Request::is('exercise*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book"></i>
                    <p>
                        Darslik
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview"
                    style="display: {{ Request::is('exercise*') ? 'block' : 'none' }};">

                    @can('exercise.show')
                        <li class="nav-item">
                            <a href="{{ route('exercises.index') }}"
                               class="nav-link {{ Request::is('exercise*') ? 'active' : '' }}">
                                <i class="fa-solid fa-share"></i>
                                <p>Biriktirish</p>
                            </a>

                        </li>
                    @endcan
                </ul>

            </li>
            <li class="nav-item has-treeview">
                <a href="#"
                   class="nav-link {{ Request::is('attendance_logs*') ? 'active' : '' }}">
                    <i class="fa-solid fa-clipboard-check"></i>
                    <p>
                        Davomat
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview"
                    style="display: {{ Request::is('attendance_logs*') ? 'block' : 'none' }};">

                    @can('attendance_log.show')
                        <li class="nav-item">
                            <a href="{{ route('attendance_logs.index') }}"
                               class="nav-link {{ Request::is('attendance_logs*') ? 'active' : '' }}">
                                <i class="fa-solid fa-check"></i>
                                <p>Davomat jurnali</p>
                            </a>
                        </li>

                    @endcan
                </ul>

            </li>

            <li class="nav-item has-treeview">
                <a href="#"
                   class="nav-link {{ Request::is('teachers*') ? 'active' : '' }}">
                    <i class="fa-solid fa-square-poll-vertical"></i>
                    <p>
                        Natijalar
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview"
                    style="display: {{ Request::is('teachers*') || Request::is('role*') || Request::is('user*') ? 'block' : 'none' }};">

                    @can('result.show')
                        <li class="nav-item">
                            <a href="{{ route('results.index') }}"
                               class="nav-link {{ Request::is('teachers*') ? 'active' : '' }}">
                                <i class="fa-solid fa-user-group"></i>
                                <!-- <sub><i class="fa-solid fa-circle-plus"></i></sub> -->
                                <p>Natijalar</p>
                            </a>

                        </li>
                    @endcan

                </ul>

            </li>


            <li class="nav-item has-treeview">
                <a href="" class="nav-link">
                    <i class="fas fa-palette"></i>
                    <p>
                        @lang('global.theme')
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" style="display: none">
                    <li class="nav-item">
                        <a href="{{ route('userSetTheme', [auth()->id(), 'theme' => 'default']) }}" class="nav-link">
                            <i class="nav-icon fas fa-circle text-info"></i>
                            <p class="text">Default {{ auth()->user()->theme == 'default' ? '✅' : '' }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('userSetTheme', [auth()->id(), 'theme' => 'light']) }}" class="nav-link">
                            <i class="nav-icon fas fa-circle text-white"></i>
                            <p>Light {{ auth()->user()->theme == 'light' ? '✅' : '' }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('userSetTheme', [auth()->id(), 'theme' => 'dark']) }}" class="nav-link">
                            <i class="nav-icon fas fa-circle text-gray"></i>
                            <p>Dark {{ auth()->user()->theme == 'dark' ? '✅' : '' }}</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
