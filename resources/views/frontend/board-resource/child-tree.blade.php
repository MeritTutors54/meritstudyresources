@php
    $files = $item['files'] ?? [];
    $fileOrientation = $item['file_orientation'] ?? 1;
    $depthPadding = ($depth - 1) * 24; // 24px indent per depth level

    // Check if this item is a section/folder (has no files)
    $isSection = $item['is_group'];
@endphp

@if ($isSection)
    <div class="accordion-item mb-2 border rounded shadow-sm" style="margin-left: {{ $depthPadding }}px;">
        <div class="accordion-header d-flex align-items-center m-0 bg-light rounded-top">

            <button class="accordion-button flex-grow-1" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse-section-{{ $item['id'] }}" aria-expanded="false"
                aria-controls="collapse-section-{{ $item['id'] }}">
                <i class="fa-regular fa-folder me-2 text-primary"></i>
                <span class="fw-bold text-dark">{{ $item['name'] }}</span>
                @php
                    $count = count($item['children'] ?? []);
                @endphp

                <span class="topic-count ms-2 badge rounded-pill">
                    @if ($count > 1)
                        ({{ $count }} topics)
                    @elseif ($count == 1 )
                        ({{ $count }} topic)
                    @else
                        @php
                            $count = count($item['files']);
                        @endphp
                         ({{ $count }} files)
                    @endif
                </span>
            </button>
        </div>

        {{-- Section Body (Recursive Children) --}}
        <div id="collapse-section-{{ $item['id'] }}" class="accordion-collapse collapse show">
            <div class="accordion-body p-0">
                <ul class="topic-list list-unstyled m-0 px-3 py-1" data-list="">
                    @if (!empty($item['children']))
                        @foreach ($item['children'] as $child)
                            @include('frontend.board-resource.child-tree', [
                                'node' => $item,
                                'item' => $child,
                                'depth' => $depth + 1,
                            ])
                        @endforeach
                    @else
                        @if ($fileOrientation == 2)
                            @php
                                $groupedFiles = collect($files)->groupBy('difficulty');
                            @endphp

                            <div class="difficulty-wrapper ps-2 pt-3 pb-2">
                                @foreach ($groupedFiles as $difficulty => $difficultyFiles)
                                    @php
                                        $difficultyConfig = match ((string) $difficulty) {
                                            '1' => ['label' => 'Easy', 'class' => 'bg-success'],
                                            '2' => ['label' => 'Medium', 'class' => 'bg-warning text-dark'],
                                            '3' => ['label' => 'Hard', 'class' => 'bg-danger'],
                                            default => ['label' => 'Level ' . $difficulty, 'class' => 'bg-secondary'],
                                        };
                                    @endphp

                                    <div class="difficulty-row mb-2 d-flex align-items-center gap-3">
                                        <span class="badge {{ $difficultyConfig['class'] }} py-2 rounded-pill"
                                            style="min-width: 70px;">
                                            {{ $difficultyConfig['label'] }}
                                        </span>

                                        <div class="badge-file-list d-flex flex-wrap gap-2">
                                            @foreach ($difficultyFiles as $index => $file)
                                                <a href="{{ asset('storage/' . $file['file_path']) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 {{ $file['is_pro'] ? 'border-warning' : '' }}"
                                                    title="Paper {{ $index + 1 }}">
                                                    <i class="fa-regular fa-file-pdf"></i>
                                                    <span>Paper {{ $index + 1 }}</span>
                                                    @if ($file['is_pro'])
                                                        <span class="badge bg-warning text-dark ms-1 p-1"
                                                            style="font-size: 0.6em;">PRO</span>
                                                    @endif
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
@else
    <li class="topic-item py-2 d-flex flex-column" style="margin-left: {{ $depthPadding }}px;">
        <div class="d-flex justify-content-between align-items-center w-100">
            @if ($fileOrientation == 1)
                {{-- Item Identity Link --}}
                <a href="{{ $fileOrientation == 1 ? asset('storage/' . $files[0]['file_path']) : 'javascript:void(0)' }}"
                    {{ $fileOrientation == 1 ? 'target="_blank"' : '' }}
                    class="d-flex align-items-center text-decoration-none text-dark flex-grow-1">
                    <span class="topic-dot text-primary me-2" aria-hidden="true"></span>
                    <span class="fw-medium">{{ $item['name'] }}</span>

                    {{-- PRO Badge --}}
                    @if ($item['is_paid'] ?? false)
                        <span class="badge bg-warning text-dark ms-2" style="font-size: 0.65em;">PRO</span>
                    @endif

                    {{-- Topic Tags based on content type --}}
                    @if ($fileOrientation == 1)
                        <span class="topic-tag ms-2 text-muted small">PDF Resource</span>
                    @endif
                </a>
            @endif
        </div>
    </li>
@endif
