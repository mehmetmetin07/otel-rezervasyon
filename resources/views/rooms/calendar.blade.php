<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Oda Doluluk Takvimi') }}
        </h2>
    </x-slot>

    <!-- FullCalendar CSS - Güncel sürüm -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <!-- FullCalendar Timeline Plugin CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/timeline@5.11.3/main.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/resource-timeline@5.11.3/main.min.css">

    <div class="py-4">
        <div class="container">
            <!-- Takvim Bilgi Kartı -->
            <div class="card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-white">
                    <div class="d-flex align-items-center">
                        <i class='bx bx-calendar-event fs-3 me-2 text-primary'></i>
                        <h5 class="mb-0">Oda Doluluk Takvimi</h5>
                    </div>
                    <div class="d-flex gap-2">
                        <button id="todayBtn" class="btn btn-sm btn-outline-primary">
                            <i class='bx bx-calendar-check me-1'></i> Bugün
                        </button>
                        <div class="btn-group">
                            <button id="dayViewBtn" class="btn btn-sm btn-outline-secondary">
                                <i class='bx bx-calendar-day'></i> Gün
                            </button>
                            <button id="weekViewBtn" class="btn btn-sm btn-outline-secondary">
                                <i class='bx bx-calendar-week'></i> Hafta
                            </button>
                            <button id="monthViewBtn" class="btn btn-sm btn-outline-secondary active">
                                <i class='bx bx-calendar'></i> Ay
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Durum Göstergeleri -->
                    <div class="row g-3 mb-4">
                        <div class="col-md">
                            <div class="d-flex align-items-center p-2 rounded bg-success-subtle">
                                <div class="avatar avatar-sm bg-success-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-check text-success'></i>
                                </div>
                                <span class="fw-medium">Boş</span>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="d-flex align-items-center p-2 rounded bg-danger-subtle">
                                <div class="avatar avatar-sm bg-danger-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-x text-danger'></i>
                                </div>
                                <span class="fw-medium">Dolu</span>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="d-flex align-items-center p-2 rounded bg-primary-subtle">
                                <div class="avatar avatar-sm bg-primary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-bookmark text-primary'></i>
                                </div>
                                <span class="fw-medium">Rezerve</span>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="d-flex align-items-center p-2 rounded bg-warning-subtle">
                                <div class="avatar avatar-sm bg-warning-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-broom text-warning'></i>
                                </div>
                                <span class="fw-medium">Temizleniyor</span>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="d-flex align-items-center p-2 rounded bg-secondary-subtle">
                                <div class="avatar avatar-sm bg-secondary-subtle rounded-circle me-2 d-flex align-items-center justify-content-center">
                                    <i class='bx bx-wrench text-secondary'></i>
                                </div>
                                <span class="fw-medium">Bakımda</span>
                            </div>
                        </div>
                    </div>

                    <!-- Takvim -->
                    <div id="calendar" class="fc-theme-standard"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar JS - Güncel sürüm -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/tr.js"></script>
    <!-- FullCalendar Timeline Plugin JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/resource-common@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timeline@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/resource-timeline@5.11.3/main.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var rooms = @json($rooms->pluck('id', 'room_number'));
            var resourcesData = [];

            // Odaları resource olarak ekle
            Object.keys(rooms).forEach(function(roomNumber) {
                resourcesData.push({
                    id: rooms[roomNumber],
                    title: roomNumber
                });
            });

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'resourceTimelineMonth',
                locale: 'tr',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: ''
                },
                editable: false,
                dayMaxEvents: true,
                height: 'auto',
                slotMinWidth: 80,
                resourceAreaHeaderContent: 'Odalar',
                resourceAreaWidth: '15%',
                resources: resourcesData,
                themeSystem: 'bootstrap5',
                slotLabelFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                events: {
                    url: '{{ route('rooms.calendar.data') }}',
                    method: 'GET',
                    failure: function() {
                        // Daha modern hata bildirimi
                        const errorToast = document.createElement('div');
                        errorToast.className = 'position-fixed bottom-0 end-0 p-3';
                        errorToast.style.zIndex = '5';
                        errorToast.innerHTML = `
                            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header bg-danger text-white">
                                    <i class='bx bx-error-circle me-2'></i>
                                    <strong class="me-auto">Hata</strong>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    Rezervasyon verileri yüklenirken bir hata oluştu.
                                </div>
                            </div>
                        `;
                        document.body.appendChild(errorToast);
                        setTimeout(() => {
                            errorToast.remove();
                        }, 5000);
                    }
                },
                resourceLabelDidMount: function(info) {
                    info.el.addEventListener('click', function() {
                        window.location.href = '/rooms/' + info.resource.id;
                    });
                    info.el.style.cursor = 'pointer';
                    info.el.classList.add('fw-medium');
                }
            });

            calendar.render();

            // Özel butonlar için olay dinleyicileri
            document.getElementById('todayBtn').addEventListener('click', function() {
                calendar.today();
            });

            document.getElementById('dayViewBtn').addEventListener('click', function() {
                calendar.changeView('resourceTimelineDay');
                updateActiveButton('dayViewBtn');
            });

            document.getElementById('weekViewBtn').addEventListener('click', function() {
                calendar.changeView('resourceTimelineWeek');
                updateActiveButton('weekViewBtn');
            });

            document.getElementById('monthViewBtn').addEventListener('click', function() {
                calendar.changeView('resourceTimelineMonth');
                updateActiveButton('monthViewBtn');
            });

            function updateActiveButton(activeId) {
                const buttons = ['dayViewBtn', 'weekViewBtn', 'monthViewBtn'];
                buttons.forEach(id => {
                    const btn = document.getElementById(id);
                    if (id === activeId) {
                        btn.classList.add('active');
                    } else {
                        btn.classList.remove('active');
                    }
                });
            }

            // Takvim stillerini özelleştir
            const calendarEl = document.querySelector('.fc');
            if (calendarEl) {
                calendarEl.classList.add('shadow-sm', 'rounded');
            }
        });
    </script>
</x-app-layout>
