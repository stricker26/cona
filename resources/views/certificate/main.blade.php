<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        
        <link rel="stylesheet" href="{{ URL::asset('css/certificate.css') }}">
    </head>
    <!-- <body onload="window.print()"> -->
    <body>
        @foreach($candidate as $c)
        <?php 
            $candidate_name = strtoupper($c->name);
            $candidate_position = strtoupper($c->position);
        ?>
            
            

		<div class="page">
            <div class="page_body">
                <div class="page_header">
                    <h1>LIBERAL PARTY OF THE PHILIPPINES</h1>
                    <p>BALAY Expo Centro Building, EDSA cor. MacArthur Avenue, Araneta Center, Cubao, Quezon City<br>
                        Tel. (02) 709-3826/ (Fax: (02) 709-3826 Mobile: (63) 9175378915, (63) 9998889482<br>
                        www.liberalparty.org.ph
                    </p>
                    <img src="{{ URL::asset('img/certificate/cert_logo.png') }}" alt="" class="logo">
                </div>

                <br>
                <p>
                    Republic of the Philippines&nbsp;&nbsp;&nbsp;&nbsp;}<br>
                    Quezon City&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;} S.S.<br>
                </p>
                <br>
                <br>
                <h1>CERTIFICATE OF NOMINATION AND ACCEPTANCE</h1>
                <br>
                <p class="indented">
                    By virtue of the powers and authority vested in me by the Constitution and By-Laws of the Liberal Party, I, the President of the Party and duly authorized signatory for and in behalf of the party, hereby nominate:
                </p>
                <br>
                <br>
                <h2>{{$candidate_name}}</h2>
                <p style="text-align: center;">Address: {{$c->address}}</p>
                <br>
                <p>
                    as the Party’s official candidate in the May 13, 2019

                @if($candidate_position == 'GOVERNOR' || $candidate_position == 'VICE GOVERNOR' || $candidate_position == 'BOARD MEMBER')
                    National and Local Elections for the position of <span>{{$candidate_position}}</span> in the province of
                
                @elseif($candidate_position == 'REPRESENTATIVE')
                    National, Local and ARMM Regional Elections for the position of <span>{{$candidate_position}}</span> in the 
                    
                @elseif($candidate_position == 'MAYOR' || $candidate_position == 'VICE MAYOR' || $candidate_position == 'COUNCILOR')

                    National, Local and ARMM Regional Elections for the position of <span>{{$candidate_position}}</span> in the 
                @endif

                <span>{{$c->administrative_address}}</span>, Philippines.</p>
                <br>
                <br>
                <p class="indented">
                    <span>IN WITNESS WHEREOF</span>, I hereunto affix my signature this ____ day of ________2018, in______________, Philippines.
                </p>
                <br>
                <br>
                <p>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>FRANCIS N. PANGILINAN</span>
                </p>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;President
                </p>
                <br>
                <br>
                <p>
                    <span>SUBSCRIBED AND SWORN TO</span> before me this ___ day of ____________ 2018, at Quezon City, Metro Manila, affiant exhibiting to me an identification document/card which contains a photograph and signature bearing No. __________ issued by ________________on _____________ at _____________, Philippines.
                </p>
                <br>
                <br>
                <br>
                <p>
                    Doc. No. ____<br>
                    Page No. ____ <br>
                    Book No. ____<br>
                    Series of  2018.<br>
                </p>
                <br>
                <br>
                <h2 style="text-decoration: underline;">
                    ACCEPTANCE/CONFORMITY OF THE CANDIDATE:
                </h2>
                <br>
                <p class="indented">
                    I hereby voluntarily accept the foregoing nomination.
                </p>
                <br>
                <br>
                <div class="sign">
                    <h2>{{$candidate_name}}</h2>
                    <p>
                        <br>
                        ______________________<br>
                        Date of Acceptance<br>
                        <br>
                    </p>
                </div>
            </div>
		    <div class="page-break"></div>
            <div class="pledge">
                <div class="pledge_logo">
                    <img src="{{ URL::asset('img/certificate/pledge_logo.jpg') }}" alt="">
                </div>
                <br>
                <h1>Panata ng mga Kandidato</h1>
                <p class="pledge_subtitle">ng Partido Liberal para sa Eleksyon 2019</p>
                <br>
                <br>
                <p>
                    Kinikilala ko na sa pagpanday ng isang progresibo, pantay-pantay, at demokratikong Pilipinas, mahalaga ang mga lider-politikal na nakikinig, nakikipag-ugnayan, at nagbibigay-inspirasyon sa taumbayan para kumilos;<br>
                    <br>
                    Naniniwala ako sa pagkakapantay-pantay at kalayaan, katuwiran at bayanihan, mga prinsipyong nakasaad sa Salig ang Batas ng Partido at sa LP Declaration nang 2018, na may pagtuon sa pasya ng liderato na gawing tunay na partido ng mamamayan ang LP.<br>
                    <br>
                    Ako, ang nakalagdang opisyal na kandidato ng Partido Liberal para {{$c->administrative_address}}
                    sa eleksyon 2019, ay,
                </p>
                <br>
                <ul>
                    <li>
                        Nangangakong masigasig na paglingkuran ang sambayanang Pilipino, itaguyod at ipagtanggol ang mga patakaran para sa pagkapantay-pantay, tupdin ang batas nang walang takot o kinikilingan, galangin ang mga karapatang-pantao, kundenahin ang extra-judicial killings, ipagtanggol ang Saligang Batas at ang pambansang teritoryo, magpasimula ng mga aksyong magbibigay-daan sa pagiging bukas, pukawin ang damdamin ng taumbayan na makilahok sa mga gawaing sibiko, pigilan ang nakawan at katiwalian sa gobyerno, labanan ang diktadurya, tumutol sa batas-militar, at itaguyod ang katotohanan: at<br><br>
                    </li>
                    <li>
                        Sumusumpang tumulong sa pagbubuo ng LP bilang tunay na partido ng mamamayan, katawanin ang ating pamantayan ng pag-asal (may paninindigan, pakikipagkapwa, galak, tyaga, pamumuno, at husay), mag-ambag sa programang pampamahalaan ng Partido, maghikayat ng suporta at aksyon para sa Partido, mangalap ng mga volunteer at bagong kasapi para sa Partido na kaisa sa ating mga paninindigan, lalo na ang mga lider na hindi politiko, tumulong sa pag-organisa ng chapter ng Partido sa aming lokalidad, sundin ang mga alituntunin ng Partido, tumulong na magbuo ng isang propesyunal na organisasyon ng LP sa pamamagitan ng pagbayad ng aking Party dues, at magsumikap para sa tagumpay ng Partido sa nalalapit na eleksyon 2019.<br><br>
                    </li>
                </ul>
                <p>
                    Nilalagdaan ko ang dokumentong ito, taimtim na umaanib / nagbabalik sa Partido Liberal ng Pilipinas, at sumasang-ayon na ang pagsuway sa mga probisyon nito ay maaaring maging batayan para madisiplina.<br>
                </p>
                <br>
                <br>
                <br>
                <br>
                <div class="sign">
                    
                    Pangalan at Lagda<br>
                    Kandidato para {{$candidate_position}} sa {{$c->administrative_address}}<br>
                    Petsa ng Pagpirma:<br>
                </div>
            </div>
            <div class="page-break"></div>
            <div class="pledge pledge_eng">
                <h1>Personal Pledge</h1>
                <p class="pledge_subtitle">of Liberal Party Candidates for the 2019 Elections</p>
                <br>
                <br>
                <p>Recognizing that political leaders play a fundamental role in building a progressive, equitable, and democratic Philippines, but only if they listen to, connect with, and inspire the people to action;<br>
                <br>
                Firmly believing in the values of fairness and freedom, social justice and solidarity, as stated in the Party Constitution and the LP Declaration of 2018, with focus on the leadership’s directive to transform the Party into a genuine people’s party,<br>
                <br>
                I, the undersigned official Liberal Party candidate for {{$candidate_position}} in {{$c->address}} in the 2019 elections,</p>
                <br>
                <ul>
                    <li>Commit to tirelessly serve the Filipino people, advocate for and defend policies that combat inequality, abide by the rule of law without fear or favor, respect human rights, condemn extra-judicial killings, defend the Constitution and our territorial integrity, institute actions that enable transparency, inspire the people to engage in civic activities, stop graft and corruption, fight dictatorship, oppose martial law, and uphold the truth; and</li><br><br>
                    <li>Pledge to help redefine the Party as a true people’s party, embody our code of conduct (PEOPLE: principled, empathetic, optimistic, persistent, leader, excellent), contribute to the Party program of government, inspire support and action for the Party, recruit volunteers and new Party members who share our values, especially non-politician leaders, help organize Party chapters in my locality, comply with Party rules, help build a professional LP organization by paying my Party dues, and work for the Party’s victory in the upcoming 2019 elections.</li>
                </ul>

                <p> In signing this document, I solemnly affiliate / renew my affiliation with Partido Liberal ng Pilipinas, agreeing that failure to adhere to its provisions may be a ground for disciplinary action.</p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div class="pledge_footer">
                    <img src="{{ URL::asset('img/certificate/pledge_footer.jpg') }}" alt="">
                </div>
                
            </div>
        </div> 

        @endforeach
    </body></html>