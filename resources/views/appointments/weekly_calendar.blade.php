<!DOCTYPE html>
<html>
<head>
    <title>Appointments</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body>
<header>
    @include('includes.header')
</header>
<div class="content-table">
    <br />
    <h1 class="text-center">Appointments</h1>
    <br />

    <div id="calendar"></div>

</div>

<script>

    $(document).ready(function () {

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#calendar').fullCalendar({
            editable:true,
            defaultView: 'agendaWeek',
            header:{
                left:'prev,next today',
                center:'title',
                right:'agendaWeek'
            },
            events:'/appointments/calendar/{{$doctor}}',
            selectable:true,
            height: 640,
            selectHelper: true,
            minTime: "08:00:00",
            maxTime: "18:00:00",
            handleWindowResize: true,
            slotEventOverlap: false,
            selectOverlap: false,
            eventOverlap:false,
            eventRender: function(event, element) {
                element.append( "<span class='removebtn'>X</span>" );
                element.find(".removebtn").click(function() {
                    $('#calendar').fullCalendar('removeEvents',event._id);
                });
            },
            select:function(start, end, allDay)
            {
                var confirmed = confirm("Create an appointment?");

                if(confirmed)
                {
                    start = $.fullCalendar.formatDate(start, 'Y-MM-DD HH:mm:ss');
                    end = $.fullCalendar.formatDate(end, 'Y-MM-DD HH:mm:ss');

                    $.ajax({
                        data:{
                            start: start,
                            end: end,
                            doctor_id: {{$doctor}},
                            type: 'add'
                        },
                        success:function(data)
                        {
                            window.location.href = "/appointments/create?start=" + start + "&end=" + end + "&doctor_id=" + {{$doctor}};
                            // calendar.fullCalendar('refetchEvents');
                            // alert("Event Created Successfully");
                        }
                    })
                }
            },
            eventResize: function(event, delta)
            {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url:"/appointments/calendar/action",
                    type:"POST",
                    data:{
                        title: title,
                        start: start,
                        end: end,
                        id: id,
                        type: 'update'
                    },
                    success:function(response)
                    {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Updated Successfully");
                    }
                })
            },
            eventDrop: function(event, delta)
            {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url:"/appointments/calendar/action",
                    type:"POST",
                    data:{
                        title: title,
                        start: start,
                        end: end,
                        id: id,
                        type: 'update'
                    },
                    success:function(response)
                    {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Updated Successfully");
                    }
                })
            },

            eventClick:function(event)
            {
                if(confirm("Are you sure you want to remove it?"))
                {
                    var id = event.id;
                    $.ajax({
                        url:"/appointments/calendar/action",
                        type:"POST",
                        data:{
                            id:id,
                            type:"delete"
                        },
                        success:function(response)
                        {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Deleted Successfully");
                        }
                    })
                }
            }
        });

    });

</script>

</body>
</html>
