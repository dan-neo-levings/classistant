<html
            xmlns:o='urn:schemas-microsoft-com:office:office'
            xmlns:w='urn:schemas-microsoft-com:office:word'
            xmlns='http://www.w3.org/TR/REC-html40'>
    <head>
        <title>Generate a document Word</title>
        <!--[if gte mso 9]-->
        <xml>
            <w:WordDocument>
                <w:View>Print</w:View>
                <w:Zoom>90</w:Zoom>
                <w:DoNotOptimizeForBrowser/>
            </w:WordDocument>
        </xml>
        <!-- [endif]-->
        <style>
            p.MsoFooter, li.MsoFooter, div.MsoFooter{
                margin: 0cm;
                margin-bottom: 0001pt;
                mso-pagination:widow-orphan;
                font-size: 12.0 pt;
                text-align: right;
            }


            @page Section1 {
                 size:595.45pt 841.7pt;
                 margin:.5n .5in .5in .5in;
                 mso-header-margin:.5in;
                 mso-footer-margin:.5in;
                 mso-paper-source:0;
             }

            div.Section1 {page:Section1;}

            @page Section2 {
                size:841.7pt 595.45pt;
                mso-page-orientation:landscape;
                margin:.5in .5in .5in .5in;
                mso-header-margin:.5in;
                mso-footer-margin:.5in;
                mso-paper-source:0;
            }

            div.Section2 {page:Section2;}

            th, td {
                border-collapse: collapse;
                border:1px solid black;
                padding:5px;
            }
        </style>
    </head>
    <body>
        <div class="Section2">
            <h1 style="color:#aaaaaa;font-family:'Arial', sans-serif">Scheme of work</h1>
            <p style="color:#222222;font-family:'Arial', sans-serif"><b>Course:</b> {{ $lessons[0]->cl->name }}</p>
            <p style="color:#222222;font-family:'Arial', sans-serif"><b>Unit:</b> {{ $lessons[0]->subject }}</p>
            <p style="color:#222222;font-family:'Arial', sans-serif"><b>Created by:</b> {{ \Illuminate\Support\Facades\Auth::user()->name }}</p>
            <table style="width:100%;font-family:'Arial', sans-serif;border:1px solid black;font-size:12px;">
                <tr>
                    <th>Date/Week</th>
                    <th>Topic/Content</th>
                    <th>Learning Outcomes/Objectives</th>
                    <th>Student Activities</th>
                    <th>Resources</th>
                    <td><b>How learning will be assessed</b><br />A: Observation<br/> B: Q&amp;A<Br/> C: Practical Tasks<br/> D: Written Task<br/> E: Other</td>
                    <td><b>Links to ESM</b><br/>A: Being Healthy<br/> B: Staying safe<br/> C: Enjoying and Achieving<br/> D: Making a positive contribution<br/> E: Achieving Economic Well Being</td>
                </tr>
                @foreach($lessons as $lesson)
                <tr>
                    <td>{{ $lesson->date->format('jS F') }}</td>
                    <td>{{ $lesson->topic }}</td>
                    <td>{!! $lesson->objectives !!}</td>
                    <td style="font-weight: normal !important;">
                        @foreach($lesson->stages as $stage)
                            <b>{{ $stage->stage }}</b><br />
                            {!! $stage->activity !!}<br/><br/>
                        @endforeach
                    </td>
                    <td>
                        @foreach($lesson->stages as $stage)
                            <b>{{ $stage->resources }}</b><br /><br />
                        @endforeach
                    </td>
                    <td>A/B/C/D/E</td>
                    <td>A/B/C/D/E</td>
                </tr>
                @endforeach

            </table>


         </div>


    </body>
</html>
