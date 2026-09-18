<?php

namespace Database\Seeders;

use App\Models\BoardResource;
use App\Models\BoardResourceFile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $root = BoardResource::create([
            'resubcategory_id' => 2,
            'name' => 'Year 1 Pure Mathematics',
            'is_group' => true,
        ]);

        $createItemWithFiles = function ($parentId, $name, $difficulties = ['Medium', 'Hard']) use ($root) {
            $item = BoardResource::create([
                'resubcategory_id' => 2,
                'parent_id' => $parentId ?? $root->id,
                'name' => $name,
                'is_group' => false,
            ]);

            foreach ($difficulties as $diff) {
                for ($i = 1; $i <= 2; $i++) {
                    BoardResourceFile::create([
                        'curriculum_node_id' => $item->id,
                        'title' => "{$diff} {$i}",
                        'difficulty' => $diff,
                        'is_pro' => $diff === 'Hard',
                        'file_path' => "worksheets/{$item->slug}-{$diff}-{$i}.pdf",
                    ]);
                }
            }
        };

        $createGroup = function ($name) use ($root) {
            return BoardResource::create([
                'resubcategory_id' => 2,
                'parent_id' => $root->id,
                'name' => $name,
                'is_group' => true,
            ]);
        };

        $createItemWithFiles(null, 'Algebraic Expressions');

        $quadraticsGroup = $createGroup('Quadratics');
        $createItemWithFiles($quadraticsGroup->id, 'Quadratics');
        $createItemWithFiles($quadraticsGroup->id, '2.2 Completing the Square');
        $createItemWithFiles($quadraticsGroup->id, '2.4 The Discriminant');

        $eqGroup = $createGroup('Equations and Inequalities');
        $createItemWithFiles($eqGroup->id, '3.5 Quadratic Inequalities');
        $createItemWithFiles($eqGroup->id, 'Graphs and Transformations');
        $createItemWithFiles($eqGroup->id, 'Straight Line Graphs');

        $circlesGroup = $createGroup('Circles');
        $createItemWithFiles($circlesGroup->id, 'Circles');
        $createItemWithFiles($circlesGroup->id, '6.2 Equation of a Circle');

        $algGroup = $createGroup('Algebraic Methods');
        $createItemWithFiles($algGroup->id, 'Algebraic Methods');
        $createItemWithFiles($algGroup->id, '7.3 The Factor Theorem');
        $createItemWithFiles($algGroup->id, 'The Binomial Expansion');
        $createItemWithFiles($algGroup->id, 'Trigonometric Ratios');

        $trigGroup = $createGroup('Trigonometric Identities and Equations');
        $createItemWithFiles($trigGroup->id, 'Trigonometric Identities and Equations');
        $createItemWithFiles($trigGroup->id, '10.4 Solving Trigonometric Equations');
        $createItemWithFiles($trigGroup->id, 'Vectors');

        $diffGroup = $createGroup('Differentiation');
        $createItemWithFiles($diffGroup->id, 'Differentiation');
        $createItemWithFiles($diffGroup->id, '12.2 Differentiation from first principles');

        $createItemWithFiles(null, 'Integration');
        $createItemWithFiles(null, 'Exponentials and Logarithms');
    }
}
