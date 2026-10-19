<?php

namespace Database\Seeders;

use App\Models\CurriculumCourse;
use App\Models\CurriculumPhase;
use App\Models\CurriculumSubject;
use App\Models\CurriculumYear;
use App\Models\LessonResourceType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/*
 * Fills the teacher library with starting data:
 *   phases → years → subjects → resource types → Year 3 Maths (9 units, 72 lessons)
 *
 * Run:  php artisan db:seed --class=TeacherLibrarySeeder
 * Safe to run again — it uses updateOrCreate, so nothing is duplicated.
 */
class TeacherLibrarySeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // ----- STEP 1 + 2: phases and their year groups
            $primary   = CurriculumPhase::updateOrCreate(['slug' => 'primary'],   ['name' => 'Primary',   'sort_order' => 1]);
            $secondary = CurriculumPhase::updateOrCreate(['slug' => 'secondary'], ['name' => 'Secondary', 'sort_order' => 2]);

            foreach (range(1, 6) as $n) {
                CurriculumYear::updateOrCreate(['slug' => "year-$n"], ['phase_id' => $primary->id, 'name' => "Year $n", 'sort_order' => $n]);
            }
            foreach (range(7, 11) as $n) {
                CurriculumYear::updateOrCreate(['slug' => "year-$n"], ['phase_id' => $secondary->id, 'name' => "Year $n", 'sort_order' => $n]);
            }

            // ----- STEP 3: subjects
            $subjects = [
                ['Maths', 'maths', 'calculator'],
                ['English', 'english', 'book'],
                ['Science', 'science', 'lightbulb'],
            ];
            foreach ($subjects as $i => [$name, $slug, $icon]) {
                CurriculumSubject::updateOrCreate(['slug' => $slug], ['name' => $name, 'icon' => $icon, 'sort_order' => $i + 1]);
            }

            // ----- STEP 7: resource types (the four icons on each lesson row + homework)
            $types = [
                ['Lesson plan', 'plan', 'journal-text'],
                ['Slides', 'slides', 'easel'],
                ['Classwork', 'classwork', 'pencil-square'],
                ['Answers', 'answers', 'check2-square'],
                ['Homework', 'homework', 'house'],
            ];
            foreach ($types as $i => [$name, $slug, $icon]) {
                LessonResourceType::updateOrCreate(['slug' => $slug], ['name' => $name, 'icon' => $icon, 'sort_order' => $i + 1]);
            }

            // ----- STEP 4–6: Year 3 Maths course, units and lessons
            $course = CurriculumCourse::updateOrCreate(
                ['slug' => 'year-3-maths'],
                [
                    'year_id'             => CurriculumYear::where('slug', 'year-3')->value('id'),
                    'subject_id'          => CurriculumSubject::where('slug', 'maths')->value('id'),
                    'title'               => 'Year 3 Maths',
                    'curriculum_label'    => 'England National Curriculum',
                    'intro'               => 'Find a topic, open a teaching step and choose the resources you need.',
                    'planned_weeks'       => 36,
                    'has_weekly_homework' => true,
                ]
            );

            $step = 0;   // counts every lesson in the year: 2 lessons a week → week = floor(step / 2) + 1

            foreach ($this->year3Maths() as $u => [$unitTitle, $lessons]) {
                $unitNo = $u + 1;

                $unit = $course->units()->updateOrCreate(
                    ['unit_number' => $unitNo],
                    ['title' => $unitTitle, 'slug' => Str::slug($unitTitle)]
                );

                foreach ($lessons as $l => $title) {
                    $lessonNo = $l + 1;

                    $unit->lessons()->updateOrCreate(
                        ['lesson_number' => $lessonNo],
                        [
                            'code'        => sprintf('Y3-U%02d-L%02d', $unitNo, $lessonNo),
                            'title'       => $title,
                            'slug'        => Str::slug($title),
                            'week_number' => intdiv($step, 2) + 1,
                        ]
                    );

                    $step++;
                }
            }
        });
    }

    /** Year 3 Maths teaching sequence — replace titles with your own if they differ. */
    private function year3Maths(): array
    {
        return [
            ['Place Value', ['Hundreds Tens and Ones', 'Partitioning and Number Words', 'Number Lines and Estimates', 'Comparing and Ordering to 1000', 'Counting in 4s 8s 50s and 100s', 'Ten and One Hundred More or Less']],
            ['Addition and Subtraction', ['Add and Subtract Ones', 'Add and Subtract Tens', 'Add and Subtract Hundreds', 'Spot the Pattern', 'Add a 3-Digit and a 1-Digit Number', 'Add a 3-Digit and a 2-Digit Number', 'Add Two 3-Digit Numbers', 'Subtract a 1-Digit Number from a 3-Digit Number', 'Subtract a 2-Digit Number from a 3-Digit Number', 'Subtract Two 3-Digit Numbers', 'Estimate Answers', 'Use Inverse Operations to Check']],
            ['Multiplication and Division', ['Equal Groups', 'Using Arrays', 'The 3 Times-Table', 'Divide by 3', 'The 4 Times-Table', 'Divide by 4', 'The 8 Times-Table', 'Divide by 8', 'Multiply 2-Digit by 1-Digit Numbers', 'Divide 2-Digit by 1-Digit Numbers', 'Scaling Problems', 'How Many Ways?']],
            ['Fractions', ['Unit Fractions and Denominators', 'Compare and Order Unit Fractions', 'Non-Unit Fractions and Numerators', 'Compare and Order Non-Unit Fractions', 'Fractions and Scales', 'Fractions on a Number Line', 'Count in Fractions', 'Equivalent Fractions on a Number Line', 'Equivalent Fractions as Bar Models', 'Fractions of a Set of Objects', 'Add Fractions', 'Subtract Fractions']],
            ['Length Mass Capacity and Perimeter', ['Measure in Metres and Centimetres', 'Measure in Millimetres', 'Equivalent Lengths', 'Compare and Add Lengths', 'Measure Perimeter', 'Calculate Perimeter', 'Measure Mass in Grams and Kilograms', 'Measure Capacity in Millilitres and Litres']],
            ['Money', ['Pounds and Pence', 'Convert Pounds and Pence', 'Add Money', 'Subtract Money and Give Change']],
            ['Time', ['Roman Numerals to XII', 'Tell the Time to 5 Minutes', 'Tell the Time to the Minute', 'Read Time on a Digital Clock', 'Use am and pm', 'Years Months and Days', 'Days and Hours', 'Hours Minutes and Seconds']],
            ['Shapes Lines Angles and Turns', ['Turns and Angles', 'Right Angles', 'Compare Angles', 'Horizontal and Vertical Lines', 'Parallel and Perpendicular Lines', 'Describe 2D and 3D Shapes']],
            ['Statistics', ['Interpret Pictograms', 'Draw Pictograms', 'Interpret Bar Charts', 'Draw Bar Charts and Use Tables']],
        ];
    }
}
