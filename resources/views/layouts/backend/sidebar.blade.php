<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar position-relative">
        <div class="multinav">
            <div class="multinav-scroll" style="height: 100%;">
                <!-- sidebar menu-->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">Dashboard</li>
                    {{-- Dashboard --}}
                    <li class="{{ request()->is('admin') ? 'active' : '' }}">
                        <a href="{{ route("admin.dashboard") }}">
                            <i class="icon-Layout-4-blocks">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="header">Operations</li>
                    {{--Past Paper--}}
                    <li class="treeview {{ request()->is('admin/categories*') ? 'active menu-open' : '' }}">
                        <a href="#">
                            <i class="icon-Write">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            <span>Past Paper</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('viewPastPaper', Auth::user())
                                <li class="{{ request()->is('admin/past-papers') ? 'active' : '' }}">
                                    <a href="{{ route('admin.past-papers.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        All Past Paper
                                    </a>
                                </li>
                            @endcan
                            @can('createPastPaper', Auth::user())
                                <li class="{{ request()->is('admin/past-papers/create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.past-papers.create') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Upload Past Paper
                                    </a>
                                </li>
                            @endcan
                            @can('viewExamSeries', Auth::user())
                                <li class="{{ request()->is('admin/exam-series*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.exam-series.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Exam Series
                                    </a>
                                </li>
                            @endcan
                            @can('viewPastPaperCategory', Auth::user())
                                <li class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.categories.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Categories
                                    </a>
                                </li>
                            @endcan
                            @can('viewPastPaperSubcategory', Auth::user())
                                <li class="{{ request()->is('admin/sub-categories*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.sub-categories.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Sub Categories
                                    </a>
                                </li>
                            @endcan
                            @can('viewPastPaperResubcategory', Auth::user())
                                <li class="{{ request()->is('admin/resub-categories*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.resub-categories.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Resub Categories
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    {{--Blog--}}
                    <li class="treeview {{ request()->is('admin/blog-categories*') || request()->is('admin/blogs*') ? 'active menu-open' : '' }}">
                        <a href="#">
                            <i class="icon-File">
                                <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                            </i>
                            <span>Blog</span>
                            <span class="pull-right-container">
					            <i class="fa fa-angle-right pull-right"></i>
					        </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('viewBlog', Auth::user())
                                <li class="{{ request()->is('admin/blogs*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.blogs.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Blog List
                                    </a>
                                </li>
                            @endcan
                            @can('viewBlogCategory', Auth::user())
                                <li class="{{ request()->is('admin/blog-categories*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.blog-categories.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Blog Category
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    {{-- Study Materials --}}
                    <li class="treeview {{  request()->is('admin/subjects*') || request()->is('admin/educational-levels*') || request()->is('admin/courses*') || request()->is('admin/resources*') ? 'active menu-open' : '' }}">
                        <a href="#">
                            <i class="icon-Chart-pie"><span class="path1"></span><span class="path2"></span></i>
                            <span>Study Materials</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('viewStudyMaterialUpload', Auth::user())
                                <li class="{{ request()->is('admin/resources*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.resources.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Manage Resources
                                    </a>
                                </li>
                            @endcan
                            @can('viewStudyMaterialTopic', Auth::user())
                                <li class="{{ request()->is('admin/topics*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.topics.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Manage Topics
                                    </a>
                                </li>
                            @endcan
                            @can('viewStudyMaterialSubject', Auth::user())
                                <li class="{{ request()->is('admin/subjects*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.subjects.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Manage Subject
                                    </a>
                                </li>
                            @endcan
                            @can('viewEducationalLevel', Auth::user())
                                <li class="{{ request()->is('admin/educational-levels*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.educational-levels.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Educational Level
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @can('viewSubscriptionPlan', Auth::user())
                        <li class="header">Subscription Section</li>
                        <li class="treeview {{ request()->is('admin/subscription-plans*') ? 'active menu-open' : '' }}">
                            <a href="#">
                                <i class="icon-Library">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <span>Subscription</span>
                                <span class="pull-right-container">
					            <i class="fa fa-angle-right pull-right"></i>
					        </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ request()->is('admin/subscription-plans*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.subscription-plans.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Manage
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    <li class="header">Ecommerce Section</li>
                    <li class="treeview ">
                        <a href="#">
                            <i class="icon-Cart"><span class="path1"></span><span class="path2"></span></i>
                            <span>Shop</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-right pull-right"></i>
					        </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('viewProduct', Auth::user())
                                <li class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.products.index') }}">
                                        <i class="icon-Commit"><span class="path1"></span><span
                                                class="path2"></span></i>
                                        Manage Product
                                    </a>
                                </li>
                            @endcan
                            @can('viewBookVariant', Auth::user())
                                <li class="{{ request()->is('admin/book-variants*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.book-variants.index') }}">
                                        <i class="icon-Commit"><span class="path1"></span><span
                                                class="path2"></span></i>
                                        Book Variant
                                    </a>
                                </li>
                            @endcan
                            @can('viewBookSubject', Auth::user())
                                <li class="{{ request()->is('admin/book-subjects*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.book-subjects.index') }}">
                                        <i class="icon-Commit"><span class="path1"></span><span
                                                class="path2"></span></i>
                                        Book Subject
                                    </a>
                                </li>
                            @endcan
                            @can('viewBookCategory', Auth::user())
                                <li class="{{ request()->is('admin/book-categories*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.book-categories.index') }}">
                                        <i class="icon-Commit"><span class="path1"></span><span
                                                class="path2"></span></i>
                                        Book Category
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="icon-Cart"><span class="path1"></span><span class="path2"></span></i>
                            <span>Orders</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-right pull-right"></i>
					        </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('viewOrderDetails', Auth::user())
                                <li class="{{ request()->is('admin/manage-orders*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.manage.order') }}">
                                        <i class="icon-Commit"><span class="path1"></span><span
                                                class="path2"></span></i>
                                        Manage Order
                                    </a>
                                </li>
                            @endcan
                            @can('viewDeliveryCharge', Auth::user())
                                <li class="{{ request()->is('admin/delivery-charge*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.delivery-charge.index') }}">
                                        <i class="icon-Commit"><span class="path1"></span><span
                                                class="path2"></span></i>
                                        Delivery Charge
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    @can('viewCoupon', Auth::user())
                        <li class="treeview {{ request()->is('admin/coupons*') ? 'active menu-open' : '' }}">
                            <a href="#">
                                <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
                                <span>Coupon</span>
                                <span class="pull-right-container">
					                <i class="fa fa-angle-right pull-right"></i>
					            </span>
                            </a>
                            <ul class="treeview-menu">
                                <li class="{{ request()->is('admin/coupons*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.coupons.index') }}">
                                        <i class="icon-Commit"><span class="path1"></span><span
                                                class="path2"></span></i>
                                        Manage
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    <li class="header">Site & Other</li>
                    <li class="treeview {{ request()->is('admin/seo-settings') || request()->is('admin/site-settings') ? 'active menu-open' : '' }}">
                        <a href="#">
                            <i class="icon-User">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            <span>Manage Site</span>
                            <span class="pull-right-container">
					            <i class="fa fa-angle-right pull-right"></i>
					        </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('viewSiteSettings', Auth::user())
                                <li class="{{ request()->is('admin/site-settings*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.site.settings') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Settings
                                    </a>
                                </li>
                            @endcan
                            @can('viewInquires', Auth::user())
                                <li class="{{ request()->is('admin/customer-inquiry') ? 'active' : '' }}">
                                    <a href="{{ route('admin.customer.inquiry') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Customer Inquiry
                                    </a>
                                </li>
                            @endcan

                            @can('viewTestimonial', Auth::user())
                                <li class="{{ request()->is('admin/testimonials*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.testimonials.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Testimonials
                                    </a>
                                </li>
                            @endcan
                            @can('viewNewsLatter', Auth::user())
                                <li class="{{ request()->is('admin/newsletter-emails*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.newsletter.emails') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        News Letter Emails
                                    </a>
                                </li>
                            @endcan
                            @can('viewSocial', Auth::user())
                                <li class="{{ request()->is('admin/socials*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.socials.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Socials
                                    </a>
                                </li>
                            @endcan
                            @can('viewSEO', Auth::user())
                                <li class="{{ request()->is('admin/seo-settings*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.seo-settings.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        SEO
                                    </a>
                                </li>
                            @endcan
                            @can('viewPolicy', Auth::user())
                                <li class="{{ request()->is('admin/policies*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.policies.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        Policy
                                    </a>
                                </li>
                            @endcan
                            @can('viewFAQ', Auth::user())
                                <li class="{{ request()->is('admin/faqs*') ? 'active' : '' }}">
                                    <a href="{{ route('admin.faqs.index') }}">
                                        <i class="icon-Commit">
                                            <span class="path1"></span><span class="path2"></span>
                                        </i>
                                        FAQs
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="icon-Chat-check"><span class="path1"></span><span class="path2"></span></i>
                            <span>Admin Stuff</span>
                            <span class="pull-right-container">
					  <i class="fa fa-angle-right pull-right"></i>
					</span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{ route('admin.stuffs.index') }}">
                                    <i class="icon-Commit">
                                        <span class="path1"></span><span class="path2"></span></i>
                                    Manage Stuffs
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <div class="sidebar-footer">
        <a href="javascript:void(0)" class="link" data-bs-toggle="tooltip" title="Settings"><span
                class="icon-Settings-2"></span></a>
        <a href="mailbox.html" class="link" data-bs-toggle="tooltip" title="Email"><span
                class="icon-Mail"></span></a>
        <a href="javascript:void(0)" class="link" data-bs-toggle="tooltip" title="Logout"><span
                class="icon-Lock-overturning"><span class="path1"></span><span class="path2"></span></span></a>
    </div>
</aside>
