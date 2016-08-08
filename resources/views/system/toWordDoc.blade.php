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


                @page Section1{
                    size: 21cm 29.7cm;
                    margin: 2cm 2cm 2cm 2cm;
                    mso-page-orientation: portrait;
                    mso-footer:f1;
                }

                @page Section2{
                    size: 21cm 29.7cm;
                    margin: 2cm 2cm 2cm 2cm;
                    mso-page-orientation: portrait;
                    mso-footer:f1;
                }
                th {
                    text-align:left;
                }
                div.Section1 { page:Section1;}
                div.Section2 { page:Section2;}
            </style>
        </head>
            <body>
            <div class="Section1">
        <h1 style="color:#aaaaaa;font-family:'Arial', sans-serif">LESSON PLAN</h1>
        <table style="width:100%;font-family:'Arial', sans-serif">
            <tr>
                <th>Teacher</th>
                <td style="border:1px solid black;padding:10px 20px">{{ $lesson->cl->user->name }} </td>
                <th>Programme</th>
                <td style="border:1px solid black;padding:10px 20px">{{ $lesson->cl->name }}</td>
            </tr>
            <tr>
                <th>Subject</th>
                <td style="border:1px solid black;padding:10px 20px">{{ $lesson->topic }}</td>
                <th>Lesson Topic</th>
                <td style="border:1px solid black;padding:10px 20px">{{ $lesson->subject }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td style="border:1px solid black;padding:5px 10px">{{ $lesson->date->toFormattedDateString() }}</td>

                <th>Room</th>
                <td style="border:1px solid black;padding:5px 10px">{{ $lesson->room }}</td>

            </tr>
        </table>
        <table style="width:100%;font-family:'Arial', sans-serif">
            <tr>
                <th>Time of Class</th>
                <td style="border:1px solid black;padding:5px 10px">{{ $lesson->time_start }}</td>
                <td>to</td>
                <td style="border:1px solid black;padding:5px 10px">{{ $lesson->time_end }}</td>
                <th>Number Of Students</th>
                <td style="border:1px solid black;padding:5px 10px">{{ $lesson->cl->no_of_students }}</td>
            </tr>
        </table>
                <br />
        <table width="100%" style="border-collapse: collapse;font-family:'Arial', sans-serif">
            <tr style="background:#dddddd">
                <th style="border:1px solid black;padding:10px 20px">Lesson objectives</th>
            </tr>
            <tr>
                <td style="border:1px solid black;padding:10px 20px">{!! $lesson->objectives !!}</td>
            </tr>
            <tr style="background:#dddddd">
                <th style="border:1px solid black;padding:10px 20px">Notes:</th>
            </tr>
            <tr>
                <td style="border:1px solid black;padding:10px 20px">Class-Specific Notes: {!! $lesson->cl->notes !!} <br /><br />{!! $lesson->notes !!}</td>
            </tr>
        </table>
</div>
            <br clear=all style='mso-special-character:line-break;page-break-after:always' />
            <div class="section2">
                <h1 style="color:#aaaaaa;font-family:'Arial', sans-serif">STAGES OF LEARNING</h1>

            <table width="100%" style="border-collapse: collapse;font-family:'Arial', sans-serif">
                <tr style="background:#dddddd">
                    <th style="border:1px solid black;padding:10px 20px">Stage</th>
                    <th style="border:1px solid black;padding:10px 20px">Teacher and Student Activities
                        including Checking Learning
                    </th>
                    <th style="border:1px solid black;padding:10px 20px">Resources<BR/>
                        Including;<BR/>
                        -	references for differentiated learning<BR/>
                        -	support from the LA
                    </th>
                </tr>
                @foreach($lesson->stages as $stage)
                <tr>
                    <td style="border:1px solid black;padding:10px 20px"><?= $stage['stage'] ?></td>
                    <td style="border:1px solid black;padding:10px 20px"><?= $stage['activity'] ?></td>
                    <td style="border:1px solid black;padding:10px 20px"><?= str_replace(',','<br />', $stage['resources']) ?></td>
                </tr>
                @endforeach
            </table>

    </body>
</html>
