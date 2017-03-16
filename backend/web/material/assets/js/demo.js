type = ['','info','success','warning','danger'];
demo = {
    initPickColor: function(){
        $('.pick-class-label').click(function(){
            var new_class = $(this).attr('new-class');
            var old_class = $('#display-buttons').attr('data-class');
            var display_div = $('#display-buttons');
            if(display_div.length) {
            var display_buttons = display_div.find('.btn');
            display_buttons.removeClass(old_class);
            display_buttons.addClass(new_class);
            display_div.attr('data-class', new_class);
            }
        });
    },

    initFormExtendedDatetimepickers: function(){
        $('.datetimepicker').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove'
            }
         });
    },

    initDocumentationCharts: function(){
        /* ----------==========     Daily Sales Chart initialization For Documentation    ==========---------- */

        dataDailySalesChart = {
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
            series: [
                [12, 17, 7, 17, 23, 18, 38]
            ]
        };

        optionsDailySalesChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: { top: 0, right: 0, bottom: 0, left: 0},
        }

        var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);

        md.startAnimationForLineChart(dailySalesChart);
    },

    initDashboardPageCharts: function(){

        /* ----------==========     Daily Sales Chart initialization    ==========---------- */

        dataDailySalesChart = {
            labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
            series: [
                [12, 17, 7, 17, 23, 18, 38]
            ]
        };

        optionsDailySalesChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: { top: 0, right: 0, bottom: 0, left: 0},
        }

        var dailySalesChart = new Chartist.Line('#dailySalesChart', dataDailySalesChart, optionsDailySalesChart);

        md.startAnimationForLineChart(dailySalesChart);



        /* ----------==========     Completed Tasks Chart initialization    ==========---------- */

        dataCompletedTasksChart = {
            labels: ['12am', '3pm', '6pm', '9pm', '12pm', '3am', '6am', '9am'],
            series: [
                [230, 750, 450, 300, 280, 240, 200, 190]
            ]
        };

        optionsCompletedTasksChart = {
            lineSmooth: Chartist.Interpolation.cardinal({
                tension: 0
            }),
            low: 0,
            high: 1000, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
            chartPadding: { top: 0, right: 0, bottom: 0, left: 0}
        }

        var completedTasksChart = new Chartist.Line('#completedTasksChart', dataCompletedTasksChart, optionsCompletedTasksChart);

        // start animation for the Completed Tasks Chart - Line Chart
        md.startAnimationForLineChart(completedTasksChart);



        /* ----------==========     Emails Subscription Chart initialization    ==========---------- */

        var dataEmailsSubscriptionChart = {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
          series: [
            [542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895]

          ]
        };
        var optionsEmailsSubscriptionChart = {
            axisX: {
                showGrid: false
            },
            low: 0,
            high: 1000,
            chartPadding: { top: 0, right: 5, bottom: 0, left: 0}
        };
        var responsiveOptions = [
          ['screen and (max-width: 640px)', {
            seriesBarDistance: 5,
            axisX: {
              labelInterpolationFnc: function (value) {
                return value[0];
              }
            }
          }]
        ];
        var emailsSubscriptionChart = Chartist.Bar('#emailsSubscriptionChart', dataEmailsSubscriptionChart, optionsEmailsSubscriptionChart, responsiveOptions);

        //start animation for the Emails Subscription Chart
        md.startAnimationForBarChart(emailsSubscriptionChart);

    },

	showNotification: function(from, align){
    	color = Math.floor((Math.random() * 4) + 1);

    	$.notify({
        	icon: "notifications",
        	message: "Welcome to <b>Material Dashboard</b> - a beautiful freebie for every web developer."

        },{
            type: type[color],
            timer: 4000,
            placement: {
                from: from,
                align: align
            }
        });
	}



};
jQuery().ready(function () {
    sidebar = jQuery('.sidebar');
    sidebar_img_container = sidebar.find('.sidebar-background');

    full_page = jQuery('.full-page');

    sidebar_responsive = jQuery('body > .navbar-collapse');

    window_width = jQuery(window).width();

    if(window_width > 767){
        if(jQuery('.fixed-plugin .dropdown').hasClass('show-dropdown')){
            jQuery('.fixed-plugin .dropdown').addClass('open');
        }
    }

    jQuery('.fixed-plugin a').click(function(event){
        // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
        if(jQuery(this).hasClass('switch-trigger')){
            if(event.stopPropagation){
                event.stopPropagation();
            }
            else if(window.event){
                window.event.cancelBubble = true;
            }
        }
    });

    jQuery('.fixed-plugin .badge').click(function(){
        full_page_background = jQuery('.full-page-background');

        jQuery(this).siblings().removeClass('active');
        jQuery(this).addClass('active');

        var new_color = jQuery(this).data('color');

        if(sidebar.length != 0){
            sidebar.attr('data-color',new_color);
        }

        if(full_page.length != 0){
            full_page.attr('data-color',new_color);
        }

        if(sidebar_responsive.length != 0){
            sidebar_responsive.attr('data-color',new_color);
        }
    });

    jQuery('.fixed-plugin .img-holder').click(function(){
        full_page_background = jQuery('.full-page-background');

        jQuery(this).parent('li').siblings().removeClass('active');
        jQuery(this).parent('li').addClass('active');


        var new_image = jQuery(this).find("img").attr('src');

        if(sidebar_img_container.length !=0 ){
            sidebar_img_container.fadeOut('fast', function(){
                sidebar_img_container.css('background-image','url("' + new_image + '")');
                sidebar_img_container.fadeIn('fast');
            });
        }

        if(full_page_background.length != 0){

            full_page_background.fadeOut('fast', function(){
                full_page_background.css('background-image','url("' + new_image + '")');
                full_page_background.fadeIn('fast');
            });
        }

        if(sidebar_responsive.length != 0){
            sidebar_responsive.css('background-image','url("' + new_image + '")');
        }
    });

    jQuery('.switch-sidebar-image input').change(function(){
        full_page_background = jQuery('.full-page-background');

        input = jQuery(this);

        if(input.is(':checked')){
            if(sidebar_img_container.length != 0){
                sidebar_img_container.fadeIn('fast');
                sidebar.attr('data-image','#');
            }

            if(full_page_background.length != 0){
                full_page_background.fadeIn('fast');
                full_page.attr('data-image','#');
            }

            background_image = true;
        } else {
            if(sidebar_img_container.length != 0){
                sidebar.removeAttr('data-image');
                sidebar_img_container.fadeOut('fast');
            }

            if(full_page_background.length != 0){
                full_page.removeAttr('data-image','#');
                full_page_background.fadeOut('fast');
            }

            background_image = false;
        }
    });

    jQuery('.switch-sidebar-mini input').change(function(){
        body = jQuery('body');

        input = jQuery(this);

        if(lbd.misc.sidebar_mini_active == true){
            jQuery('body').removeClass('sidebar-mini');
            lbd.misc.sidebar_mini_active = false;

            if(isWindows){
                jQuery('.sidebar .sidebar-wrapper').perfectScrollbar();
            }

        }else{

            jQuery('.sidebar .collapse').collapse('hide').on('hidden.bs.collapse',function(){
                jQuery(this).css('height','auto');
            });

            if(isWindows){
                jQuery('.sidebar .sidebar-wrapper').perfectScrollbar('destroy');
            }

            setTimeout(function(){
                jQuery('body').addClass('sidebar-mini');

                jQuery('.sidebar .collapse').css('height','auto');
                lbd.misc.sidebar_mini_active = true;
            },300);
        }

        // we simulate the window Resize so the charts will get updated in realtime.
        var simulateWindowResize = setInterval(function(){
            window.dispatchEvent(new Event('resize'));
        },180);

        // we stop the simulation of Window Resize after the animations are completed
        setTimeout(function(){
            clearInterval(simulateWindowResize);
        },1000);

    });

/*    jQuery('.switch-navbar-fixed input').change(function(){
        nav = jQuery('nav.navbar').first();

        if(nav.hasClass('navbar-fixed')){
            nav.removeClass('navbar-fixed').prependTo('.main-panel');
        } else {
            nav.prependTo('.wrapper').addClass('navbar-fixed');
        }

    });*/


    /*jQuery('#twitter').sharrre({
        share: {
            twitter: true
        },
        enableHover: false,
        enableTracking: true,
        buttons: { twitter: {via: 'CreativeTim'}},
        click: function(api, options){
            api.simulateClick();
            api.openPopup('twitter');
        },
        template: '<i class="fa fa-twitter"></i> &middot; 2',
        url: 'http://demos.creative-tim.com/material-dashboard/examples/dashboard.html'
    });*/

    /*jQuery('#facebook').sharrre({
        share: {
            facebook: true
        },
        enableHover: false,
        enableTracking: true,
        click: function(api, options){
            api.simulateClick();
            api.openPopup('facebook');
        },
        template: '<i class="fa fa-facebook-square"></i> &middot; 40',
        url: 'http://demos.creative-tim.com/material-dashboard-pro/examples/dashboard.html'
    });*/

});
