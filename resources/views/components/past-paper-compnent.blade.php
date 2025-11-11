<div>
    <div class="merit-menu-item mb-3">
        <h2 class="merit-menu-header">
            <button
                {{--                class="menu-button {{ $pipe == 0 ? 'active' : '' }}" style="font-size: 24px"--}}
                {{--                type="button" data-area-id="merit-menu-id-{{ $key }}">--}}
                {{--                {{ ucfirst($title) }}--}}
            >
                hello 123
            </button>
        </h2>
        <div
{{--            id="merit-menu-id-{{ $key }}"--}}
{{--            class="merit-menu-dropdown-box {{ $pipe == 0 ? 'show' : '' }}">--}}
            class="merit-menu-dropdown-box">
            <div class="merit-menu-body">
                @if(count($papers) > 0)
                    <ul class="rplc_dropdown mt-1">
                        <li><h5>Questions</h5></li>
                        @foreach($papers as $paper)
                            <li>
                                <div class="paper-zone">
                                    @if(!empty($paper->ques_paper))
                                        <button class="past-paper-button"
                                                data-type="ques_paper"
                                                data-paper-id="{{ $paper->id }}">
                                            <i class="feather-file-text" style="font-size: 18px"></i>
                                            {{ $paper->title }}
                                        </button>
                                        <a href="{{ route('pdf.secret.view', [\App\Services\PDFService::makeSecret($paper->id, 'ques_paper')]) }}"
                                           target="_blank"
                                           class="pdf-anchor">
                                            <i class="feather-file-text"
                                               style="font-size: 18px; margin-right: 3px"></i>
                                            {{ $paper->title }}
                                        </a>

                                        <a href="{{ asset('uploads/pastpaper/' . $paper->ques_paper) }}"
                                           target="_blank"
                                           class="pdf-anchor">
                                            <i class="feather-file-text"
                                               style="font-size: 18px; margin-right: 3px"></i>
                                            {{ $paper->title }}
                                        </a>
                                    @endif

                                    @if(!empty($paper->ans_paper))
                                        <button class="ms-auto past-paper-button"
                                                data-type="ans_paper"
                                                data-paper-id="{{ $paper->id }}">
                                            <i class="feather-file-text" style="font-size: 18px"></i>
                                            Mark Scheme
                                        </button>
                                        <a href="{{ route('pdf.secret.view', [\App\Services\PDFService::makeSecret($paper->id, 'ans_paper')]) }}"
                                           target="_blank"
                                           class="ms-auto pdf-anchor">
                                            <i class="feather-file-text"
                                               style="font-size: 18px; margin-right: 3px"></i>
                                            Mark Scheme
                                        </a>
                                        <a href="{{ asset('uploads/pastpaper/' . $paper->ans_paper) }}"
                                           target="_blank"
                                           class="ms-auto pdf-anchor">
                                            <i class="feather-file-text"
                                               style="font-size: 18px; margin-right: 3px"></i>
                                            Mark Scheme
                                        </a>

                                    @endif

                                    @if($paper->have_solution == 1)
                                        <a href="#">
                                            <span class="">Solutions</span>
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
