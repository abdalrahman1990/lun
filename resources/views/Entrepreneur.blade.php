<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style>
            body {
                width: 100vw;
                height: 100vh;
                overflow-x: hidden;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
                min-height: 100vh;
            }
            .CC-logo {
                width: 300px;
                height: 96px;

                position: relative;
                margin-bottom: -30px;
            }
            .CC-lineup {
                width: 100%;
                height: 56px;
            }
            .CC-under-line {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                text-align: center;
            }
            .CC-under-line img {
                width: 240px;
                height: 55px;
                position: absolute;
                margin-top: 100px;
            }
            .CC-under-line h3 {
                font-size: 30px;
            }
            .content {
                padding-right: 15px;
                padding-left: 25px;
                margin-right: auto;
                margin-left: auto;
                margin-top: 50px;
            }
            .underline {
                text-decoration: underline;
                font-size: 26px;
            }
            .content-data p {
                font-size: 18px;
                font-weight: bold;
            }
            .content-data p span {
                font-size: 20px;
                font-weight: normal;
            }
            span {
                margin-left: 10px;
            }
        </style>
    </head>

    <body>
        <img class="CC-logo" src="{{public_path('assets/images/logo.png')}}" alt="logo">
        <img class="CC-lineup" src="{{public_path('assets/images/line1.png')}}" alt="">
        <div class="CC-under-line">
            <h3>Entrepreneur Form</h3>
            <img src="form.png" alt="">
        </div>
        <div class="content">
            <h3 class="underline">Overview</h3>
            <div class="content-data">

                 @foreach ($entrepreneurs as $item)

                        <p>Company Name :
                            <span>{{$item}}</span></p>
                        <p>
                        Company Logo
                        <br>
                        <img src="{{public_path('assets/images/form.png')}}" alt="" loading="lazy"></p>
                    <p>Currency :
                        <span>text</span></p>
                    <p>Website :
                        <span>Link</span></p>
                    <p>Are you a member ?
                        <span>Yes or No</span></p>
                    <p>Company Phase :
                        <span>Text</span></p>
                    <p>Company Category:
                        <span>Text</span></p>
                    <p>Product manufacture :
                        <span>Text</span></p>
                    <p>Customer Focus :
                        <span>Text</span></p>
                    <p>Video Link :
                        <span>Link</span></p>
                    <p>
                        Images
                        <br>
                        <img style="margin-right: 20px;"src="{{public_path('assets/images/uber-logo.png')}}" alt="" loading="lazy">
                        <img style="margin-right: 20px;" src="uber-logo.png" alt="" loading="lazy">
                        <img src="{{public_path('assets/images/uber-logo.png')}}" alt="" loading="lazy">
                    </p>
                @endforeach
            </div>
            <div class="content">
                <h3 class="underline">Team</h3>
                <div class="content-data">
                    <p>Name:
                        <span>text</span></p>
                    <p>Phone Number:
                        <span>Number</span></p>
                    <p>Linkedin:
                        <span>Link</span></p>
                    <p>Role In Team:
                        <span>text</span></p>
                    <p>Number of team members:
                        <span>Number</span></p>

                </div>
            </div>
            <div class="content">
                <h3 class="underline">Problem</h3>
                <div class="content-data">
                    <p>Client Problem:
                        <span>text</span></p>
                </div>
            </div>
            <div class="content">
                <h3 class="underline">Solutions</h3>
                <div class="content-data">
                    <p>Describe information about this app:
                        <span>text</span></p>
                </div>
            </div>
            <div class="content">
                <h3 class="underline">Market</h3>
                <div class="content-data">
                    <p>Describe the client and the market:
                        <span>text</span></p>
                    <p>value proposition:
                        <span>text</span></p>
                    <p>Competitor Names:
                        <span>text</span></p>
                    <p>Competitor Link:
                        <span>Link</span></p>
                </div>
            </div>
            <div class="content">
                <h3 class="underline">Business Model</h3>
                <div class="content-data">
                    <p>Description of project idea:
                        <span>text</span></p>
                </div>
            </div>
            <div class="content">
                <h3 class="underline">Finance</h3>
                <div class="content-data">
                    <p>Current year's revenue:
                        <span>Number</span></p>
                    <p>Gotten any funds:
                        <span>Yes or No</span></p>
                    <p>Minimum Capital seeking:<span>Number</span></p>
                    <p>Maximum Capital seeking:<span>Number</span></p>
                    <p>Company funding stage:<span>Text</span></p>
                    <p>Current funding:<span>Number</span></p>
                    <p>Expected Fund:<span>Number</span></p>
                </div>
            </div>
            <div class="content">
                <h3 class="underline">Strategy</h3>
                <div class="content-data">
                    <p>Risks:
                        <span>Text</span></p>
                </div>
            </div>
            <div class="content">
                <h3 class="underline">Others</h3>
                <div class="content-data">
                    <p>Did you participated in any accelerators or Incubators projects or programs
                        before?
                        <span>Yes or No</span></p>
                    <p>How did you know Lun Startup?
                        <span>Text</span></p>
                    <p>summary for company:<span>PDF File</span></p>
                </div>
            </div>

        </body>

    </html>