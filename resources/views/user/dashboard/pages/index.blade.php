<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>User Panel</title>
    @include('user.dashboard.include.head')
    @include('user.dashboard.pages.css.network')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body>
    <div class="container-scroller">
        @include('user.dashboard.include.header')
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper pb-0">
                    <div class="">
                        <div class="dashboard">
                            <div class="dashboard-summary">
                                <div class="summary-card" data-aos="fade-right">
                                    <i class="fa fa-gift icon"></i>
                                    <p class="text-nowrap"> Reward Bonus
                                        {{number_format(floor($user->commission_account), 0)}} (NG)</p>

                                </div>
                                <div class="summary-card" data-aos="fade-left">
                                    <i class="fa fa-gift icon"></i>
                                    <p class="text-nowrap"> Rewards Food {{number_format(floor($user->total_food), 0)}}
                                        (NG)</p>
                                </div>
                                <div class="summary-card" data-aos="fade-up">
                                    <i class="fa fa-bank icon"></i>
                                    <p class="text-nowrap"> Withdrawal Amount : {{$totalWithdrawal}} (NG)</p>
                                </div>
                                <div class="summary-card" data-aos="fade-up">
                                    <i class="fa fa-sitemap icon"></i>
                                    <p class="text-nowrap"> MATRIX MLM Network</p>
                                </div>
                                <div class="summary-card" data-aos="fade-up" style="background-color: aquamarine;">
                                    <i class="fa fa-user icon"></i>
                                    <p class="text-nowrap"> Username: {{ $user->username }}</p>
                                    <p class="text-nowrap"> User ID: {{ $user->user_id }}</p>
                                    <p class="text-nowrap"> Sponsor ID: {{ $user->sponser_id  }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        AOS.init();
    </script>
</body>

</html>