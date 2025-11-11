@extends('layouts.frontend')
@section('title','A Level Subjects')
@section('content')

    <!-- Start breadcrumb Area -->
    <div class="rbt-breadcrumb-default rbt-breadcrumb-style-3">
        <div class="breadcrumb-inner breadcrumb-dark">
            <img src="{{ asset('frontend') }}/assets/images/bg/bg-image-10.jpg" alt="Education Images">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content text-start">
                        <ul class="page-list">
                            <li class="rbt-breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                            <li>
                                <div class="icon-right"><i class="feather-chevron-right"></i></div>
                            </li>
                            <li class="rbt-breadcrumb-item active">A Level</li>
                        </ul>
                        <h2 class="title">Your Ultimate Exam Resource Hub</h2>
                        <p class="description">Our comprehensive resource collection is an invaluable asset for students striving to excel in exams and for teachers looking for dependable materials to guide their students. Explore a wide range of revision notes, exam questions, detailed model answers, past exam papers, and more, all carefully organized to make your search effortless.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb Area -->
    <div class="rbt-course-details-area ptb--60">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-12">
                    <div class="course-details-content">
                
                        
                        <div class="rbt-course-feature-box rbt-shadow-box details-wrapper mt--30" id="">
                            <div class="row g-5">
                                <!-- Start Feture Box  -->
                                <div class="col-lg-12">
                                    <p class="description">A Level Subjects</p>
                                </div>
                                @foreach ($allData as $data)
                                <div class="col-lg-3">
                                    {{-- <a href="{{ url('pastpapers',$category->slug.'/'.$subcategory->slug.'/'.$resubcategory->slug) }}"> --}}
                                    <a href="{{ url('resources/a-level/'.$data->slug) }}">

                                    <div class="section-title newDesign">
                                        <i class="fa fa-book"></i>
                                        <h4 class="rbt-title-style-3 mb--20">{{ $data->subcategory_name}} <i class="fa fa-arrow-right"></i></h4>
                                    </div>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                      
                    </div>
                  
                </div>

               
            </div>
        </div>
    </div>



@endsection