{{-- @php
    $space = '&nbsp;&nbsp;&nbsp;';
    $proSpace = '';
    $indent = str_repeat($space, $depth);

    $files = $item['files'] ?? [];
    $fileOrientation = $item['file_orientation'] ?? 1;

    $groupLeader =
        !empty($files) &&
        ($files[0]['board_resource_id'] ?? null) === $item['id'] &&
        ($item['is_section_title'] ?? false)
            ? $item['name']
            : '';
@endphp

<style>
    .underline:hover {
        text-decoration: underline;
    }

    .child-header {
        position: relative;
    }

    .pro-badge {
        position: absolute;
        background-color: #ffc107;
        color: #fff;
        left: -5px;
        padding: 1px 3px;
        border-radius: 4px;
        font-size: 12px;
    }
</style>

@if (count($files) > 0)
    @if ($fileOrientation == 1)
        <div>
            <a href="{{ asset('storage/' . $files[0]['file_path']) }}" target="_blank" class="child-link">
                {!! $indent !!}➙ {{ $item['name'] }} <i class="fa-solid fa-file-pdf"
                    style="font-size: 16px; color: red;"></i>
                <a href="{{ route('admin.board-resources.edit', $item['id']) }}">
                    <i class="fa-solid fa-pen-to-square" style="font-size: 16px; color: #ffc107;"></i>
                </a>
                <i class="fa-solid fa-trash" style="font-size: 16px; color: #dc3545;"></i>
            </a>
        </div>
    @elseif($fileOrientation == 2)
        <div class="child-group-container">
            @if (!empty($groupLeader))
                <div class="child-header">
                    {!! str_repeat($space, $depth + 1) !!} {{ $groupLeader }}
                </div>
            @endif

            <div class="child-header">
                @if ($item['is_paid'])
                    <span class="pro-badge">pro</span>
                @endif
                {!! $indent !!}✧ {{ $item['name'] }}
                <a href="{{ route('admin.board-resources.edit', $item['id']) }}">
                        <i class="fa-solid fa-pen-to-square" style="font-size: 16px; color: #ffc107;"></i>
                </a>
                <i class="fa-solid fa-trash" style="font-size: 16px; color: #dc3545;"></i>
            </div>

            @php
                $groupedFiles = collect($files)->groupBy('difficulty');
            @endphp

            @foreach ($groupedFiles as $difficulty => $difficultyFiles)
                <div class="difficulty-section d-flex gap-2">
                    <span class="difficulty-label">
                        @switch((string)$difficulty)
                            @case('1')
                                {!! str_repeat($space, 3) !!} &nbsp; Easy
                            @break

                            @case('2')
                                {!! str_repeat($space, 3) !!} &nbsp; Medium
                            @break

                            @case('3')
                                {!! str_repeat($space, 3) !!} &nbsp; Hard
                            @break

                            @default
                                Level {{ $difficulty }}
                        @endswitch
                    </span>

                    <div class="file-badges">
                        @foreach ($difficultyFiles as $index => $file)
                            <a href="{{ asset('storage/' . $file['file_path']) }}" target="_blank"
                                class="file-badge underline @if ($file['is_pro']) pro-ba @endif">
                                {{ $index + 1 }}
                                @if ($file['is_pro'])
                                    <span class="pro-tag">PRO</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@else
    @if ($item['is_section_title'] == 1)
        <div class="d-flex gap-2">
            <p class="child-name mb-0">{!! $indent !!} &nbsp; {{ $item['name'] }}</p>
            <a href="{{ route('admin.board-resources.edit', $item['id']) }}">
                <i class="fa-solid fa-pen-to-square" style="font-size: 16px; color: #ffc107;"></i></a>
            <i class="fa-solid fa-trash" style="font-size: 16px; color: #dc3545;"></i>
        </div>
    @else
        <p class="child-name mb-0">{!! $indent !!}✧ {{ $item['name'] }} ppppppp</p>
    @endif
@endif --}}


@php
    $files = $item['files'] ?? [];
    $fileOrientation = $item['file_orientation'] ?? 1;
    $depthPadding = ($depth - 1) * 24; // 24px indent per depth level
@endphp

<div class="tree-node depth-{{ $depth }}" style="margin-left: {{ $depthPadding }}px;">

    {{-- CASE 1: Has Files --}}
    @if (count($files) > 0)
        @if ($fileOrientation == 1)
            {{-- Type 1: Single PDF Resource Row --}}
            <div class="node-row file-item">
                <div class="node-content d-flex align-items-center gap-2">
                    <span class="file-type-icon pdf">
                        <i class="fa-solid fa-file-pdf"></i>
                    </span>

                    <a href="{{ asset('storage/' . $files[0]['file_path']) }}" target="_blank" class="resource-title-link">
                        {{ $item['name'] }}
                    </a>

                    @if ($item['is_paid'] ?? false)
                        <span class="badge-pro">PRO</span>
                    @endif
                </div>

                <div class="action-group">
                    <a href="{{ route('admin.board-resources.edit', $item['id']) }}" class="btn-action btn-edit" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <button type="button" class="btn-action btn-delete" title="Delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>

        @elseif($fileOrientation == 2)
            {{-- Type 2: Grouped by Difficulty --}}
            <div class="node-group-container">
                <div class="node-row group-header">
                    <div class="node-content d-flex align-items-center gap-2">
                        <span class="file-type-icon group">
                            <i class="fa-solid fa-layer-group"></i>
                        </span>
                        <span class="fw-semibold text-dark">{{ $item['name'] }}</span>

                        @if ($item['is_paid'] ?? false)
                            <span class="badge-pro">PRO</span>
                        @endif
                    </div>

                    <div class="action-group">
                        <a href="{{ route('admin.board-resources.edit', $item['id']) }}" class="btn-action btn-edit" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button type="button" class="btn-action btn-delete" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

                {{-- Difficulty Pills Section --}}
                @php
                    $groupedFiles = collect($files)->groupBy('difficulty');
                @endphp

                <div class="difficulty-wrapper">
                    @foreach ($groupedFiles as $difficulty => $difficultyFiles)
                        @php
                            $difficultyConfig = match ((string)$difficulty) {
                                '1' => ['label' => 'Easy', 'class' => 'diff-easy'],
                                '2' => ['label' => 'Medium', 'class' => 'diff-medium'],
                                '3' => ['label' => 'Hard', 'class' => 'diff-hard'],
                                default => ['label' => 'Level ' . $difficulty, 'class' => 'diff-default'],
                            };
                        @endphp

                        <div class="difficulty-row">
                            <span class="difficulty-pill {{ $difficultyConfig['class'] }}">
                                {{ $difficultyConfig['label'] }}
                            </span>

                            <div class="badge-file-list">
                                @foreach ($difficultyFiles as $index => $file)
                                    <a href="{{ asset('storage/' . $file['file_path']) }}" target="_blank"
                                       class="file-chip {{ $file['is_pro'] ? 'is-pro' : '' }}"
                                       title="Paper {{ $index + 1 }}">
                                        <span>Paper {{ $index + 1 }}</span>
                                        @if ($file['is_pro'])
                                            <span class="chip-pro-tag">PRO</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    {{-- CASE 2: No Files (Section Titles / Categories) --}}
    @else
        <div class="node-row section-item {{ $item['is_section_title'] ? 'is-section' : '' }}">
            <div class="node-content d-flex align-items-center gap-2">
                <span class="file-type-icon section">
                    <i class="fa-regular fa-folder"></i>
                </span>
                <span class="fw-semibold text-secondary">{{ $item['name'] }}</span>
            </div>

            <div class="action-group">
                <a href="{{ route('admin.board-resources.edit', $item['id']) }}" class="btn-action btn-edit" title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <button type="button" class="btn-action btn-delete" title="Delete">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
    @endif
</div>
