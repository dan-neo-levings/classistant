<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(ClassTableSeeder::class);
        $this->call(LessonsTableSeeder::class);
        $this->call(StagesTableSeeder::class);

        Model::reguard();
    }
}


class UserTableSeeder extends Seeder
{
    public function run() {
        $data = [
            [
                'name' => 'Anna Selway',
                'password' => \Illuminate\Support\Facades\Hash::make('kGtZ7M-y'), //kilo GOLF tango ZULU 7 MIKE - yankee
                'department' => 'Computing',
                'email' => 'anna.selway@highbury.ac.uk',
                'expiration' => \Carbon\Carbon::createFromDate(2016, 3, 8),
                'tutorial' => 1
            ],
            [
                'name' => 'Sue Bonner',
                'password' => \Illuminate\Support\Facades\Hash::make('-h*7!Z+a'),
                'department' => 'Computing',
                'email' => 'sue.bonner@highbury.ac.uk',
                'expiration' => \Carbon\Carbon::createFromDate(2016, 3, 8),
                'tutorial' => 1
            ],
            [
                'name' => 'Cathy Ellis',
                'password' => \Illuminate\Support\Facades\Hash::make('qXe;7z4M'),
                'department' => 'Computing',
                'email' => 'Cathy.Ellis@highbury.ac.uk',
                'expiration' => \Carbon\Carbon::createFromDate(2016, 3, 8),
                'tutorial' => 1
            ],
            [
                'name' => 'Will Marks',
                'password' => \Illuminate\Support\Facades\Hash::make('c~Y54edD'),
                'department' => 'Computing',
                'email' => 'will.marks@highbury.ac.uk',
                'expiration' => \Carbon\Carbon::createFromDate(2016, 3, 8),
                'tutorial' => 1
            ],
        ];

        foreach($data as $d) {
            \Illuminate\Support\Facades\DB::table('users')->insert($d);
        }
    }
}


class ClassTableSeeder extends Seeder
{
    public function run() {
        $data = [
            [
                'no_of_students' => 12,
                'name' => "BTEC Level 3 Software Year 1 15/16",
                'user_id' => 2
            ],
            [
                'no_of_students' => 8,
                'name' => "BTEC Level 3 Software Year 2 15/16",
                'user_id' => 2
            ],
            [
                'no_of_students' => 5,
                'name' => "Software Apprenticeship Year 2 15/16",
                'user_id' => 1
            ],
            [
                'no_of_students' => 14,
                'name' => "Level 3 Siploma in IT (Software) Year 1 15/16",
                'user_id' => 2
            ],
            [
                'no_of_students' => 6,
                'name' => "FdSc Software Year 2 15/16",
                'user_id' => 3
            ],

        ];

        foreach($data as $d) {
            \Illuminate\Support\Facades\DB::table('classes')->insert($d);
        }
    }
}

class LessonsTableSeeder extends Seeder
{
    public function run() {
        $data = [
            [
                'subject' => 'Human Computer Interaction',
                'topic' => 'Effect on HCI on society, economy and culture',
                'date' => "2015-02-09",
                'class_id' => 1,
                'objectives' => '<p class="MsoNoSpacing" style="line-height: 22.4px; margin-top: 12pt;"><span style="font-size: 12pt; font-weight: 700; line-height: 22.4px;">There must be sufficient stretch and challenge so that by the end of the lesson:</span><br></p><p class="MsoNormal" style="line-height: 22.4px;"><span style="font-weight: 700;"><span arial","sans-serif""="" style="font-size: 10pt;">All Students</span></span></p><p class="MsoNormal" style="line-height: 22.4px;"><span arial","sans-serif""="" style="font-size: 10pt;">Will be able to state at least one impact HCI has had on:<o:p></o:p></span></p><ul type="disc" style="line-height: 22.4px; margin-top: 0cm;"><li class="MsoNormal"><span arial","sans-serif""="" style="font-size: 10pt;">Society<o:p></o:p></span></li><li class="MsoNormal"><span arial","sans-serif""="" style="font-size: 10pt;">Economy<o:p></o:p></span></li><li class="MsoNormal"><span arial","sans-serif""="" style="font-size: 10pt;">Culture</span></li></ul><p class="MsoNormal" style="line-height: 22.4px;"><span style="font-weight: 700;"><span arial","sans-serif""="" style="font-size: 10pt;">Most Students</span></span></p><p class="MsoNormal" style="line-height: 22.4px;"><span arial","sans-serif""="" style="font-size: 10pt;">Will be able to evaluate the impact HCI has had on society, economy and culture.</span></p><p class="MsoNormal" style="line-height: 22.4px;"><span style="font-weight: 700;"><span arial","sans-serif""="" style="font-size: 10pt;">Some Students</span></span></p><p class="MsoNormal" style="line-height: 22.4px;"><span arial","sans-serif""="" style="font-size: 10pt;">Will be able to suggest potential long term impacts HCI could have&nbsp; on society economy and culture&nbsp;</span></p><div><span style="font-size: 12pt;"><br></span></div>',
                'notes' => '<p class="MsoNoSpacing" style="line-height: 22.4px; margin-top: 12pt;"><span style="font-size: 12pt;">For the group task, students will be allocated a group by the lecturer to ensure they have the opportunity to work with different members of the class.<o:p></o:p></span></p><p class="MsoNoSpacing" style="line-height: 22.4px; margin-top: 12pt;"><span style="font-size: 12pt;">Flipchart paper and pens needed for group task<o:p></o:p></span></p><p class="MsoNoSpacing" style="line-height: 22.4px; margin-top: 12pt;"><span style="font-size: 12pt;">All resources are available on MyCourse<o:p></o:p></span></p><div><span style="font-size: 12pt;"><br></span></div>',
                'time_start' => '15:00',
                'time_end' => '17:00',
                'room' => 'T4.003',
                'private' => 0,
                'secret_key' => 'h78FH83d'

            ],
            [
                'subject' => 'Human Computer Interaction',
                'topic' => 'Effect on HCI on society, economy and culture',
                'date' => "2015-02-09",
                'class_id' => 2,
                'objectives' => '<p class="MsoNoSpacing" style="line-height: 22.4px; margin-top: 12pt;"><span style="font-size: 12pt; font-weight: 700; line-height: 22.4px;">There must be sufficient stretch and challenge so that by the end of the lesson:</span><br></p><p class="MsoNormal" style="line-height: 22.4px;"><span style="font-weight: 700;"><span arial","sans-serif""="" style="font-size: 10pt;">All Students</span></span></p><p class="MsoNormal" style="line-height: 22.4px;"><span arial","sans-serif""="" style="font-size: 10pt;">Will be able to state at least one impact HCI has had on:<o:p></o:p></span></p><ul type="disc" style="line-height: 22.4px; margin-top: 0cm;"><li class="MsoNormal"><span arial","sans-serif""="" style="font-size: 10pt;">Society<o:p></o:p></span></li><li class="MsoNormal"><span arial","sans-serif""="" style="font-size: 10pt;">Economy<o:p></o:p></span></li><li class="MsoNormal"><span arial","sans-serif""="" style="font-size: 10pt;">Culture</span></li></ul><p class="MsoNormal" style="line-height: 22.4px;"><span style="font-weight: 700;"><span arial","sans-serif""="" style="font-size: 10pt;">Most Students</span></span></p><p class="MsoNormal" style="line-height: 22.4px;"><span arial","sans-serif""="" style="font-size: 10pt;">Will be able to evaluate the impact HCI has had on society, economy and culture.</span></p><p class="MsoNormal" style="line-height: 22.4px;"><span style="font-weight: 700;"><span arial","sans-serif""="" style="font-size: 10pt;">Some Students</span></span></p><p class="MsoNormal" style="line-height: 22.4px;"><span arial","sans-serif""="" style="font-size: 10pt;">Will be able to suggest potential long term impacts HCI could have&nbsp; on society economy and culture&nbsp;</span></p><div><span style="font-size: 12pt;"><br></span></div>',
                'notes' => '<p class="MsoNoSpacing" style="line-height: 22.4px; margin-top: 12pt;"><span style="font-size: 12pt;">For the group task, students will be allocated a group by the lecturer to ensure they have the opportunity to work with different members of the class.<o:p></o:p></span></p><p class="MsoNoSpacing" style="line-height: 22.4px; margin-top: 12pt;"><span style="font-size: 12pt;">Flipchart paper and pens needed for group task<o:p></o:p></span></p><p class="MsoNoSpacing" style="line-height: 22.4px; margin-top: 12pt;"><span style="font-size: 12pt;">All resources are available on MyCourse<o:p></o:p></span></p><div><span style="font-size: 12pt;"><br></span></div>',
                'time_start' => '15:00',
                'time_end' => '17:00',
                'room' => 'T4.003',
                'private' => 0,
                'secret_key' => 'h78FH83f'

            ],
        ];

        foreach($data as $d) {
            \Illuminate\Support\Facades\DB::table('lessons')->insert($d);
        }
    }
}

class StagesTableSeeder extends Seeder
{
    public function run() {
        $data = [
            [
                'stage' => 'Starter',
                'activity' => '<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""="">Introduce todayâ€™s
session â€“ evaluate the effects of HCI on society, culture and the economy</span></p>

<span style="font-size:11.0pt;font-family:" arial","sans-serif";mso-fareast-font-family:="" "times="" new="" roman";mso-ansi-language:en-gb;mso-fareast-language:en-us;="" mso-bidi-language:ar-sa"="">Using the PowerPoint on MyCourse, starter activity â€“
90 seconds to write down what HCI is</span>',
                'resources' => 'Whiteboard,',
                'lesson_id' => 1,
                'order_no' => 0,
                'intensity' => 2
            ],
            [
                'stage' => 'Body',
                'activity' => '<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""="">Class discussion on
the impact that HCI has had on our lives â€“ drawing information from the
exercises completed in week 1 (predictions)<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""=""><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""="">Class divided into 3
groups.&nbsp; Write down on flipchart paper
the negative and positive effects of their given topic (society, economy,
culture)<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""=""><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""="">Class
discussion on findings focusing on the positive and negative impact advances
have made<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""=""><o:p>&nbsp;</o:p></span></p>

<span style="font-size:11.0pt;font-family:" arial","sans-serif";mso-fareast-font-family:="" "times="" new="" roman";mso-ansi-language:en-gb;mso-fareast-language:en-us;="" mso-bidi-language:ar-sa"="">Individual work, planning for assignment task</span>',
                'resources' => 'Resources on MyCourse, Flipchart,',
                'lesson_id' => 1,
                'order_no' => 1,
                'intensity' => 4
            ],
            [
                'stage' => 'Review and Looking Forward',
                'activity' => '<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""="">Class discussion,
with question and answer session on todayâ€™s session to consolidate learning.<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""=""><o:p>&nbsp;</o:p></span></p>

<span style="font-size:11.0pt;font-family:" arial","sans-serif";mso-fareast-font-family:="" "times="" new="" roman";mso-ansi-language:en-gb;mso-fareast-language:en-us;="" mso-bidi-language:ar-sa"="">Inform students that next week we will be looking at
perception.&nbsp; They need to research into
this by next lesson.</span>',
                'resources' => '',
                'lesson_id' => 1,
                'order_no' => 2,
                'intensity' => 1
            ],[
                'stage' => 'Starter',
                'activity' => '<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""="">Introduce todayâ€™s
session â€“ evaluate the effects of HCI on society, culture and the economy</span></p>

<span style="font-size:11.0pt;font-family:" arial","sans-serif";mso-fareast-font-family:="" "times="" new="" roman";mso-ansi-language:en-gb;mso-fareast-language:en-us;="" mso-bidi-language:ar-sa"="">Using the PowerPoint on MyCourse, starter activity â€“
90 seconds to write down what HCI is</span>',
                'resources' => 'Whiteboard,',
                'lesson_id' => 2,
                'order_no' => 0,
                'intensity' => 2
            ],
            [
                'stage' => 'Body',
                'activity' => '<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""="">Class discussion on
the impact that HCI has had on our lives â€“ drawing information from the
exercises completed in week 1 (predictions)<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""=""><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""="">Class divided into 3
groups.&nbsp; Write down on flipchart paper
the negative and positive effects of their given topic (society, economy,
culture)<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""=""><o:p>&nbsp;</o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""="">Class
discussion on findings focusing on the positive and negative impact advances
have made<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""=""><o:p>&nbsp;</o:p></span></p>

<span style="font-size:11.0pt;font-family:" arial","sans-serif";mso-fareast-font-family:="" "times="" new="" roman";mso-ansi-language:en-gb;mso-fareast-language:en-us;="" mso-bidi-language:ar-sa"="">Individual work, planning for assignment task</span>',
                'resources' => 'Resources on MyCourse, Flipchart,',
                'lesson_id' => 2,
                'order_no' => 1,
                'intensity' => 4
            ],
            [
                'stage' => 'Review and Looking Forward',
                'activity' => '<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""="">Class discussion,
with question and answer session on todayâ€™s session to consolidate learning.<o:p></o:p></span></p>

<p class="MsoNormal"><span style="font-size:11.0pt;font-family:" arial","sans-serif""=""><o:p>&nbsp;</o:p></span></p>

<span style="font-size:11.0pt;font-family:" arial","sans-serif";mso-fareast-font-family:="" "times="" new="" roman";mso-ansi-language:en-gb;mso-fareast-language:en-us;="" mso-bidi-language:ar-sa"="">Inform students that next week we will be looking at
perception.&nbsp; They need to research into
this by next lesson.</span>',
                'resources' => '',
                'lesson_id' => 2,
                'order_no' => 2,
                'intensity' => 1
            ],
        ];

        foreach($data as $d) {
            \Illuminate\Support\Facades\DB::table('stages')->insert($d);
        }
    }
}
