<style>
    .hidden-sidebar-item{
        position: absolute!important;
        width: 100%!important;
        height: 100%!important;
        z-index: 2!important;
        opacity: 0!important;
        top: 0!important;
        bottom: 0!important;
        left: 0!important;
        right: 0!important;
    }
    .sidebar-submenu > li {
        position: relative;
    }
    .sidebar-submenu > li .badge.sidebar-submenu-badge {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        padding: 0.35em 0.65em 0.25em;
        z-index: 1;
        font-size: 10px;
        letter-spacing: 0.5px;
        font-weight: 600;
        border-radius: 10px;
    }
</style>
<div class="sidebar-wrapper" sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper">
            <a href="{{ route('admin.dashboard') }}">
                <img class="img-fluid for-light" src="{{ settings('site_logo') ?: asset('theme/images/logo/logo.png') }}" alt="{{ settings('site_name', 'Steach') }}">
                <img class="img-fluid for-dark" src="{{ settings('site_logo') ?: asset('theme/images/logo/logo_dark.png') }}" alt="{{ settings('site_name', 'Steach') }}">
            </a>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="grid"></i>
            </div>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ route('admin.dashboard') }}">
                <img class="img-fluid" src="{{ settings('site_logo') ?: asset('theme/images/logo/logo-icon.png') }}" alt="{{ settings('site_name', 'Steach') }}">
            </a>
        </div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn">
                        <a href="{{ route('admin.dashboard') }}">
                            <img class="img-fluid" src="{{ settings('site_logo') ?: asset('theme/images/logo/logo-icon.png') }}" alt="{{ settings('site_name', 'Steach') }}">
                        </a>
                        <div class="mobile-back text-end">
                            <span>Back</span>
                            <i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                        </div>
                    </li>

                    @if (admin_sidebar('dashboard'))
                    {{-- عمومی --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>عمومی</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="dashboard">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-home"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-home"></use>
                            </svg>
                            <span>داشبورد</span>
                        </a>

                        <a href="{{ route('admin.dashboard') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif

                    @if (admin_sidebar('section.support'))
                    {{-- پشتیبانی --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>پشتیبانی</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.user-requests.*') ? 'active' : '' }}"
                           href="user-requests">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-support-tickets"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-support-tickets"></use>
                            </svg>
                            <span>درخواست‌های کاربران</span>
                        </a>
                        @if (($supportUserRequestsPendingCount ?? 0) > 0)
                            <span class="badge badge-danger" title="در انتظار رسیدگی">
                                {{ ($supportUserRequestsPendingCount ?? 0) > 99 ? '99+' : $supportUserRequestsPendingCount }}
                            </span>
                        @endif

                        <a href="{{ route('admin.user-requests.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif

                    @if (admin_sidebar('section.finance'))
                    {{-- مالی --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>مالی</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.finance.*') ? 'active' : '' }}"
                           href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-ecommerce"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-ecommerce"></use>
                            </svg>
                            <span>مدیریت مالی</span>
                            @if (($paymentsPendingReceiptReviewCount ?? 0) > 0)
                                <span class="badge badge-danger text-light" title="پرداخت در انتظار بررسی رسید">
                                    {{ ($paymentsPendingReceiptReviewCount ?? 0) > 99 ? '99+' : $paymentsPendingReceiptReviewCount }}
                                </span>
                            @endif
                        </a>
                        <ul class="sidebar-submenu">
                            @if (admin_sidebar('finance.dashboard'))
                            <li>
                                <a href="finance/dashboard" class="{{ request()->routeIs('admin.finance.dashboard') ? 'active' : '' }}">داشبورد</a>
                                <a href="{{ route('admin.finance.dashboard') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                            @if (admin_sidebar('finance.orders'))
                            <li>
                                <a href="finance/orders" class="{{ request()->routeIs('admin.finance.orders.*') || request()->routeIs('admin.finance.invoices.*') ? 'active' : '' }}">سفارش‌ها و فاکتورها</a>
                                <a href="{{ route('admin.finance.orders.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                            @if (admin_sidebar('finance.payments'))
                            <li>
                                <a href="finance/payments" class="{{ request()->routeIs('admin.finance.payments.*') ? 'active' : '' }}">پرداخت‌ها</a>
                                @if (($paymentsPendingReceiptReviewCount ?? 0) > 0)
                                    <span class="badge badge-danger sidebar-submenu-badge" title="در انتظار بررسی رسید">
                                        {{ ($paymentsPendingReceiptReviewCount ?? 0) > 99 ? '99+' : $paymentsPendingReceiptReviewCount }}
                                    </span>
                                @endif
                                <a href="{{ route('admin.finance.payments.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                            @if (admin_sidebar('finance.coupons'))
                            <li>
                                <a href="finance/coupons" class="{{ request()->routeIs('admin.finance.coupons.*') ? 'active' : '' }}">کدهای تخفیف</a>
                                <a href="{{ route('admin.finance.coupons.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                            @if (admin_sidebar('finance.carts'))
                            <li>
                                <a href="finance/carts" class="{{ request()->routeIs('admin.finance.carts.*') ? 'active' : '' }}">سبدهای خرید</a>
                                <a href="{{ route('admin.finance.carts.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if (admin_sidebar('section.education'))
                    {{-- آموزش --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>آموزش</h6>
                        </div>
                    </li>
                    @if (admin_sidebar('education.packages'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.class-packages.*') || request()->routeIs('admin.class-sessions.*') || request()->routeIs('admin.enrollments.*') || request()->routeIs('admin.teacher-applications.*') || request()->routeIs('admin.substitute-requests.*') || request()->routeIs('admin.support-complaints.*') || request()->routeIs('admin.role-work-requests.*') ? 'active' : '' }}"
                           href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-file"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-file"></use>
                            </svg>
                            <span>پکیج ها</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @if (admin_sidebar('education.packages.manage'))
                            <li>
                                <a href="class-packages"
                                   class="{{ request()->routeIs('admin.class-packages.*') || request()->routeIs('admin.class-sessions.*') ? 'active' : '' }}">مدیریت پکیج‌ها </a>
                                <a href="{{ route('admin.class-packages.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                            @if (admin_sidebar('education.enrollments'))
                            <li>
                                <a href="enrollments"
                                   class="{{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">ثبت‌نام کلاس</a>
                                <a href="{{ route('admin.enrollments.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                            @if (admin_sidebar('education.teacher_applications'))
                            <li>
                                <a href="teacher-applications"
                                   class="{{ request()->routeIs('admin.teacher-applications.*') ? 'active' : '' }}">اعلام آمادگی کادر آموزشی</a>
                                <a href="{{ route('admin.teacher-applications.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                            @if (admin_sidebar('education.substitute_requests'))
                            <li>
                                <a href="substitute-requests"
                                   class="{{ request()->routeIs('admin.substitute-requests.*') ? 'active' : '' }}">درخواست جایگزینی مدرس</a>
                                <a href="{{ route('admin.substitute-requests.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                            @if (admin_sidebar('education.support_complaints'))
                            <li>
                                <a href="support-complaints"
                                   class="{{ request()->routeIs('admin.support-complaints.*') ? 'active' : '' }}">شکایت خانواده</a>
                                <a href="{{ route('admin.support-complaints.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                            @if (admin_sidebar('education.role_work_requests'))
                            <li>
                                <a href="role-work-requests"
                                   class="{{ request()->routeIs('admin.role-work-requests.*') ? 'active' : '' }}">درخواست‌های بین نقش‌ها</a>
                                <a href="{{ route('admin.role-work-requests.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if (admin_sidebar('placement'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.placement.*') ? 'active' : '' }}"
                           href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-knowledgebase"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-knowledgebase"></use>
                            </svg>
                            <span>تعیین سطح</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="placement/calendars" class="{{ request()->routeIs('admin.placement.calendars.*') ? 'active' : '' }}">تقویم‌ها</a>
                                <a href="{{ route('admin.placement.calendars.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            <li>
                                <a href="placement/slots" class="{{ request()->routeIs('admin.placement.slots.*') ? 'active' : '' }}">اسلات های تقویم</a>
                                <a href="{{ route('admin.placement.slots.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            <li>
                                <a href="placement/availabilities" class="{{ request()->routeIs('admin.placement.availabilities.*') ? 'active' : '' }}">آمادگی مدرسان</a>
                                <a href="{{ route('admin.placement.availabilities.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            <li>
                                <a href="placement/sessions" class="{{ request()->routeIs('admin.placement.sessions.*') ? 'active' : '' }}">جلسات رزرو شده</a>
                                <a href="{{ route('admin.placement.sessions.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            <li>
                                <a href="placement/teacher-performance" class="{{ request()->routeIs('admin.placement.teacher-performance.*') ? 'active' : '' }}">عملکرد مدرسان</a>
                                <a href="{{ route('admin.placement.teacher-performance.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            <li>
                                <a href="placement-quiz/submissions" class="{{ request()->routeIs('admin.placement-quiz.submissions.*') ? 'active' : '' }}">پاسخ‌های کوئیز کتبی</a>
                                <a href="{{ route('admin.placement-quiz.submissions.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if (admin_sidebar('levels'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.levels.*') ? 'active' : '' }}"
                           href="levels">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-learning"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-learning"></use>
                            </svg>
                            <span>سطح‌های آموزشی</span>
                        </a>

                        <a href="{{ route('admin.levels.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif
                    @if (admin_sidebar('assignments'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.assignments.*') || request()->routeIs('admin.assignment-types.*') ? 'active' : '' }}"
                           href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-task"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-task"></use>
                            </svg>
                            <span>تکالیف</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @if (admin_sidebar('assignments.list'))
                            <li>
                                <a href="assignments"
                                   class="{{ request()->routeIs('admin.assignments.*') ? 'active' : '' }}">لیست تکالیف</a>
                                <a href="{{ route('admin.assignments.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                            @if (admin_sidebar('assignments.types'))
                            <li>
                                <a href="assignment-types"
                                   class="{{ request()->routeIs('admin.assignment-types.*') ? 'active' : '' }}">انواع تکلیف</a>
                                <a href="{{ route('admin.assignment-types.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if (admin_sidebar('lesson_handouts'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.lesson-handouts.*') ? 'active' : '' }}"
                           href="lesson-handouts">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-file"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-file"></use>
                            </svg>
                            <span>جزوه‌های کلاس</span>
                        </a>

                        <a href="{{ route('admin.lesson-handouts.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif
                    @if (admin_sidebar('student_score_criteria'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.student-score-criteria.*') ? 'active' : '' }}"
                           href="student-score-criteria">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-calendar"></use>
                            </svg>
                            <span>معیارهای نمره‌دهی</span>
                        </a>

                        <a href="{{ route('admin.student-score-criteria.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif
                    @if (admin_sidebar('holidays'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.holidays.*') ? 'active' : '' }}"
                           href="holidays">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-calendar"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-calender"></use>
                            </svg>
                            <span>تعطیلات</span>
                        </a>

                        <a href="{{ route('admin.holidays.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif

                    @endif

                    @if (admin_sidebar('section.performance'))
                    {{-- عملکرد --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>عملکرد</h6>
                        </div>
                    </li>
                    @if (admin_sidebar('survey_forms'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.survey-forms.*') ? 'active' : '' }}"
                           href="survey-forms">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-calendar"></use>
                            </svg>
                            <span>فرم‌های نظرسنجی</span>
                        </a>

                        <a href="{{ route('admin.survey-forms.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif
                    @if (admin_sidebar('staff_performance_reports'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.staff-performance-reports.*') ? 'active' : '' }}"
                           href="staff-performance-reports">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-charts"></use>
                            </svg>
                            <span>گزارش عملکرد کادر</span>
                        </a>

                        <a href="{{ route('admin.staff-performance-reports.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.staff-performance-payroll-reports.*') ? 'active' : '' }}"
                           href="staff-performance-payroll-reports">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-charts"></use>
                            </svg>
                            <span>گزارش عملکرد کادر جدید</span>
                        </a>

                        <a href="{{ route('admin.staff-performance-payroll-reports.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif

                    @endif

                    @if (admin_sidebar('section.chat'))
                    {{-- چت --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>چت</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.chats.*') ? 'active' : '' }}"
                           href="chats">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-chat"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-chat"></use>
                            </svg>
                            <span>چت‌ها</span>
                        </a>

                        <a href="{{ route('admin.chats.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>

                    @endif

                    @if (admin_sidebar('section.announcements'))
                    {{-- اطلاعیه‌ها --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>اطلاعیه‌ها</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.announcements.*') || request()->routeIs('admin.announcement-rules.*') ? 'active' : '' }}"
                           href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-email"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-email"></use>
                            </svg>
                            <span>اطلاعیه‌ها</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="announcements" class="{{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">لیست اطلاعیه‌ها</a>
                                <a href="{{ route('admin.announcements.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            <li>
                                <a href="announcement-rules" class="{{ request()->routeIs('admin.announcement-rules.*') ? 'active' : '' }}">اطلاعیه‌های خودکار</a>
                                <a href="{{ route('admin.announcement-rules.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                        </ul>
                    </li>

                    @endif



                    @if (admin_sidebar('section.marketing'))
                        <li class="sidebar-main-title">
                            <div>
                                <h6>مارکتینگ</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.marketing.*') ? 'active' : '' }}"
                               href="{{ route('admin.marketing.campaigns.index') }}">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-learning"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-learning"></use>
                                </svg>
                                <span>کمپین‌ها</span>
                            </a>
                            <a href="{{ route('admin.marketing.campaigns.index') }}" class="hidden-sidebar-item"></a>
                        </li>
                    @endif

                    @if (admin_sidebar('section.reports'))
                        {{-- گزارش‌گیری --}}
                        <li class="sidebar-main-title">
                            <div>
                                <h6>گزارش‌گیری</h6>
                            </div>
                        </li>
                        <li class="sidebar-list">
                            <i class="fa fa-thumb-tack"></i>
                            <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                               href="#">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-charts"></use>
                                </svg>
                                <svg class="fill-icon">
                                    <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-charts"></use>
                                </svg>
                                <span>گزارش‌ها</span>
                            </a>
                            <ul class="sidebar-submenu">
                                @if (admin_sidebar('reports.support.funnel'))
                                    <li>
                                        <a href="reports/support/funnel" class="{{ request()->routeIs('admin.reports.support.funnel') ? 'active' : '' }}">قیف لندینگ و تبدیل</a>
                                        <a href="{{ route('admin.reports.support.funnel') }}" class="hidden-sidebar-item"></a>
                                    </li>
                                @endif
                                @if (admin_sidebar('reports.support.admin_follow_ups'))
                                    <li>
                                        <a href="reports/support/admin-follow-ups" class="{{ request()->routeIs('admin.reports.support.admin-follow-ups') ? 'active' : '' }}">پیگیری درخواست‌ها</a>
                                        <a href="{{ route('admin.reports.support.admin-follow-ups') }}" class="hidden-sidebar-item"></a>
                                    </li>
                                @endif
                                @if (admin_sidebar('reports.management.acquisition'))
                                    <li>
                                        <a href="reports/management/acquisition" class="{{ request()->routeIs('admin.reports.management.acquisition') ? 'active' : '' }}">جذب مخاطب و فروش</a>
                                        <a href="{{ route('admin.reports.management.acquisition') }}" class="hidden-sidebar-item"></a>
                                    </li>
                                @endif
                                @if (admin_sidebar('reports.management.sales'))
                                    <li>
                                        <a href="reports/management/sales" class="{{ request()->routeIs('admin.reports.management.sales') ? 'active' : '' }}">فروش و ثبت‌نام</a>
                                        <a href="{{ route('admin.reports.management.sales') }}" class="hidden-sidebar-item"></a>
                                    </li>
                                @endif
                                @if (admin_sidebar('reports.management.admin_assisted'))
                                    <li>
                                        <a href="reports/management/admin-assisted" class="{{ request()->routeIs('admin.reports.management.admin-assisted') ? 'active' : '' }}">همراهی ادمین در خرید</a>
                                        <a href="{{ route('admin.reports.management.admin-assisted') }}" class="hidden-sidebar-item"></a>
                                    </li>
                                @endif
                                @if (admin_sidebar('reports.journeys'))
                                    <li>
                                        <a href="reports/journeys" class="{{ request()->routeIs('admin.reports.journeys.*') ? 'active' : '' }}">مسیر کاربران</a>
                                        <a href="{{ route('admin.reports.journeys.index') }}" class="hidden-sidebar-item"></a>
                                    </li>
                                @endif
                                @if (admin_sidebar('reports.education.class_sessions'))
                                    <li>
                                        <a href="reports/education/class-sessions" class="{{ request()->routeIs('admin.reports.education.*') ? 'active' : '' }}">وضعیت لحظه‌ای آموزش</a>
                                        <a href="{{ route('admin.reports.education.class-sessions') }}" class="hidden-sidebar-item"></a>
                                    </li>
                                @endif
                                @if (admin_sidebar('reports.support_performance.supporters'))
                                    <li>
                                        <a href="reports/support-performance/supporters" class="{{ request()->routeIs('admin.reports.support-performance.*') ? 'active' : '' }}">عملکرد پشتیبان های آموزشی</a>
                                        <a href="{{ route('admin.reports.support-performance.supporters') }}" class="hidden-sidebar-item"></a>
                                    </li>
                                @endif
                                @if (admin_sidebar('reports.student_retention.churn'))
                                    <li>
                                        <a href="reports/student-retention/churn" class="{{ request()->routeIs('admin.reports.student-retention.*') ? 'active' : '' }}">ریزش و وفاداری</a>
                                        <a href="{{ route('admin.reports.student-retention.churn') }}" class="hidden-sidebar-item"></a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif



                @if (admin_sidebar('section.users'))
                    {{-- مدیریت کاربران --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>مدیریت کاربران</h6>
                        </div>
                    </li>
                    @if (admin_sidebar('users'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                           href="users">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-user"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-user"></use>
                            </svg>
                            <span>کاربران</span>
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif
                    @if (admin_sidebar('contracts'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.contracts.*') ? 'active' : '' }}"
                           href="contracts">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-file"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-file"></use>
                            </svg>
                            <span>قراردادها</span>
                        </a>

                        <a href="{{ route('admin.contracts.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif
                    @if (admin_sidebar('user_roles'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.user-roles.*') ? 'active' : '' }}"
                           href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-job-search"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-job-search"></use>
                            </svg>
                            <span>نقش‌های کاربری</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @foreach (config('user.requestable_roles', []) as $roleKey => $roleConfig)
                                <li class="sidebar-main-title px-3 py-1">
                                    <span class="f-light">{{ $roleConfig['label_plural'] ?? $roleKey }}</span>
                                </li>
                                <li>
                                    <a
                                        href="user-roles/{{ $roleKey }}/requests"
                                        class="{{ request()->routeIs('admin.user-roles.requests*') && request()->route('role') === $roleKey ? 'active' : '' }}"
                                    >درخواست‌ها</a>
                                    <a href="{{ route('admin.user-roles.requests', $roleKey) }}"
                                       class="hidden-sidebar-item"></a>
                                </li>
                                <li>
                                    <a
                                        href="user-roles/{{ $roleKey }}/members"
                                        class="{{ (request()->routeIs('admin.user-roles.members.*') && request()->route('role') === $roleKey) ? 'active' : '' }}"
                                    >لیست {{ $roleConfig['label_plural'] ?? $roleKey }}</a>
                                    <a href="{{ route('admin.user-roles.members.index', $roleKey) }}"
                                       class="hidden-sidebar-item"></a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @if (admin_sidebar('characters'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.characters.*') ? 'active' : '' }}"
                           href="characters">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-gallery"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-gallery"></use>
                            </svg>
                            <span>کاراکترها</span>
                        </a>

                        <a href="{{ route('admin.characters.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif
                    @if (admin_sidebar('otp_codes'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.otp-codes.*') ? 'active' : '' }}"
                           href="otp-codes">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-email"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-email"></use>
                            </svg>
                            <span>کدهای OTP</span>
                        </a>

                        <a href="{{ route('admin.otp-codes.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif

                    @if (admin_sidebar('wallets'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.finance.wallets.*') || request()->routeIs('admin.finance.withdrawal-requests.*') ? 'active' : '' }}"
                           href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-ecommerce"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-ecommerce"></use>
                            </svg>
                            <span>کیف پول‌ها</span>
                        </a>
                        <ul class="sidebar-submenu">
                            @if (admin_sidebar('finance.wallets'))
                            <li>
                                <a href="finance/wallets" class="{{ request()->routeIs('admin.finance.wallets.*') ? 'active' : '' }}">لیست کیف پول‌ها</a>
                                <a href="{{ route('admin.finance.wallets.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                            @if (admin_sidebar('finance.withdrawals'))
                            <li>
                                <a href="finance/withdrawal-requests" class="{{ request()->routeIs('admin.finance.withdrawal-requests.*') ? 'active' : '' }}">درخواست برداشت‌ها</a>
                                <a href="{{ route('admin.finance.withdrawal-requests.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @endif

                    @if (admin_sidebar('section.launcher'))
                    {{-- لانچر --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>لانچر</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.launcher-logs.*') ? 'active' : '' }}"
                           href="launcher/logs">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-clipboard"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-clipboard"></use>
                            </svg>
                            <span>لاگ‌های لانچر</span>
                        </a>

                        <a href="{{ route('admin.launcher-logs.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>

                    @endif

                    @if (admin_sidebar('section.external'))
                    {{-- سیستم‌های خارجی --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>سیستم‌های خارجی</h6>
                        </div>
                    </li>
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.external-systems.*') ? 'active' : '' }}"
                           href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-internationalization"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-internationalization"></use>
                            </svg>
                            <span>یکپارچه‌سازی</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="external-systems/didar"
                                   class="{{ request()->routeIs('admin.external-systems.didar') ? 'active' : '' }}">دیدار (CRM)</a>
                                <a href="{{ route('admin.external-systems.didar') }}" class="hidden-sidebar-item"></a>
                            </li>
                        </ul>
                    </li>

                    @endif

                    @if (admin_sidebar('section.settings'))
                    {{-- تنظیمات --}}
                    <li class="sidebar-main-title">
                        <div>
                            <h6>تنظیمات</h6>
                        </div>
                    </li>
                    @if (admin_sidebar('settings.site'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                           href="settings">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-layout"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-layout"></use>
                            </svg>
                            <span>تنظیمات سایت</span>
                        </a>

                        <a href="{{ route('admin.settings.edit') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif
                    @if (admin_sidebar('admins'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}"
                           href="admins">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-social"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-social"></use>
                            </svg>
                            <span>مدیران</span>
                        </a>

                        <a href="{{ route('admin.admins.index') }}"
                           class="hidden-sidebar-item"></a>
                    </li>
                    @endif
                    @if (admin_sidebar('roles_permissions'))
                    <li class="sidebar-list">
                        <i class="fa fa-thumb-tack"></i>
                        <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'active' : '' }}"
                           href="#">
                            <svg class="stroke-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#stroke-board"></use>
                            </svg>
                            <svg class="fill-icon">
                                <use href="{{ asset('theme/svg/icon-sprite.svg') }}#fill-board"></use>
                            </svg>
                            <span>نقش‌ها و دسترسی‌ها</span>
                        </a>
                        <ul class="sidebar-submenu">
                            <li>
                                <a href="admin-panel/roles" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">نقش‌ها</a>
                                <a href="{{ route('admin.roles.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                            <li>
                                <a href="permissions" class="{{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">دسترسی‌ها</a>
                                <a href="{{ route('admin.permissions.index') }}" class="hidden-sidebar-item"></a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    @endif
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
