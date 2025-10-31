<x-app-layout>
    <x-slot name="title">Follow-up Calendar</x-slot>
    <x-slot name="subtitle">View and manage all scheduled follow-ups</x-slot>

    <div class="card">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                events: '{{ route('calendar.events') }}',
                eventClick: function(info) {
                    var eventObj = info.event;
                    alert('Follow-up: ' + eventObj.title + '\n' +
                          'Status: ' + eventObj.extendedProps.status + '\n' +
                          'Remarks: ' + (eventObj.extendedProps.remarks || 'No remarks'));
                },
                eventDidMount: function(info) {
                    info.el.style.cursor = 'pointer';
                },
                height: 'auto',
                aspectRatio: 1.8
            });
            calendar.render();
        });
    </script>
    @endpush
</x-app-layout>

