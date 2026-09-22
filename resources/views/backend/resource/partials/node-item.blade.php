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
                    <a href="{{ route('admin.board-resources.edit', $item['id']) }}" class="btn-action btn-edit"
                        title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                    <button type="button" class="btn-action btn-delete nodeDeletionBtn" title="Delete"
                        data-id="{{ $item['id'] }}" data-name="{{ $item['name'] }}"
                        data-url="{{ route('admin.board-resources.destroy', $item['id']) }}">
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
                        <a href="{{ route('admin.board-resources.edit', $item['id']) }}" class="btn-action btn-edit"
                            title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <button type="button" class="btn-action btn-delete nodeDeletionBtn" title="Delete"
                            data-id="{{ $item['id'] }}" data-name="{{ $item['name'] }}"
                            data-url="{{ route('admin.board-resources.destroy', $item['id']) }}">
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
                            $difficultyConfig = match ((string) $difficulty) {
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
                @if ($item['is_paid'] ?? false)
                    <span class="badge-pro">PRO</span>
                @endif
            </div>

            <div class="action-group">
                <a href="{{ route('admin.board-resources.edit', $item['id']) }}" class="btn-action btn-edit"
                    title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
                <button type="button" class="btn-action btn-delete nodeDeletionBtn" title="Delete"
                    data-id="{{ $item['id'] }}" data-name="{{ $item['name'] }}"
                    data-url="{{ route('admin.board-resources.destroy', $item['id']) }}">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
    @endif
</div>
