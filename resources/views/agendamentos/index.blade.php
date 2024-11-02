@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-3 d-none d-md-block">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title mb-4">Calendário Completo</h6>
            <div id='external-events' class='external-events'>
              <h6 class="mb-2 text-muted">Eventos Arrastáveis</h6>
              <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                <div class='fc-event-main'>Aniversário</div>
              </div>
              <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                <div class='fc-event-main'>Novo Projeto</div>
              </div>
              <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                <div class='fc-event-main'>Reunião com Cliente</div>
              </div>
              <div class='fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event'>
                <div class='fc-event-main'>Viagem de Trabalho</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-9">
        <div class="card">
          <div class="card-body">
            <div id='fullcalendar'></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal para detalhes do evento -->
<div id="eventModal" class="modal fade">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="modalTitle" class="modal-title"></h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"><span class="visually-hidden">fechar</span></button>
      </div>
      <div id="modalBody" class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para adicionar evento -->
<div id="createEventModal" class="modal fade">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Adicionar Evento</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"><span class="visualmente-hidden">Fechar</span></button>
      </div>
      <div class="modal-body">
        <form id="addEventForm">
          <div class="mb-3">
            <label for="eventTitle" class="form-label">Título do Evento</label>
            <input type="text" class="form-control" id="eventTitle" placeholder="Título do Evento">
          </div>
          <div class="mb-3">
            <label for="eventDescription" class="form-label">Descrição</label>
            <textarea class="form-control" id="eventDescription" placeholder="Descrição"></textarea>
          </div>
          <div class="mb-3">
            <label for="eventStartDate" class="form-label">Data de Início</label>
            <input type="datetime-local" class="form-control" id="eventStartDate">
          </div>
          <div class="mb-3">
            <label for="eventEndDate" class="form-label">Data de Fim</label>
            <input type="datetime-local" class="form-control" id="eventEndDate">
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="allDayCheckbox">
            <label class="form-check-label" for="allDayCheckbox">
              Evento de dia inteiro
            </label>
          </div>
          <div class="mb-3">
            <label for="eventColor" class="form-label">Cor do Evento</label>
            <input type="color" class="form-control form-control-color" id="eventColor" value="#3a87ad" title="Escolha a cor do evento">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button id="saveEventButton" class="btn btn-primary">Salvar Evento</button>
      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/fullcalendar/index.global.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('fullcalendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'pt-br',
            initialView: 'dayGridMonth',
            events: '/calendar/events',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            editable: true,
            selectable: true,
            select: function(info) {
                document.getElementById('eventStartDate').value = info.startStr;
                document.getElementById('eventEndDate').value = info.endStr;
                document.getElementById('allDayCheckbox').checked = false;
                document.getElementById('eventColor').value = '#3a87ad'; // Cor padrão
                toggleDateTimeFields(false);
                const createEventModal = new bootstrap.Modal(document.getElementById('createEventModal'));
                createEventModal.show();
            },
            eventClick: function(info) {
                const title = info.event.title || 'Sem título';
                const description = info.event.extendedProps.description || 'Sem descrição';
                const location = info.event.extendedProps.location || 'Local não especificado';
                const attendees = info.event.extendedProps.attendees || [];
                const reminders = info.event.extendedProps.reminders || [];
                const color = info.event.backgroundColor || '#000';
                const imageUrl = info.event.extendedProps.imageUrl || '';

                const remindersList = reminders.length ? reminders.map(r => `<li>${r.method}: ${r.minutes} minutos antes</li>`).join('') : 'Sem lembretes';
                const attendeesList = attendees.length ? attendees.map(a => `<li>${a.displayName} (${a.email})</li>`).join('') : 'Sem convidados';

                document.getElementById('modalTitle').innerText = title;
                document.getElementById('modalBody').innerHTML = `
                    <p><strong>Início:</strong> ${moment(info.event.start).format('DD/MM/YYYY HH:mm')}</p>
                    <p><strong>Fim:</strong> ${moment(info.event.end).format('DD/MM/YYYY HH:mm')}</p>
                    <p><strong>Descrição:</strong> ${description}</p>
                    <p><strong>Local:</strong> ${location}</p>
                    <p><strong>Convidados:</strong><ul>${attendeesList}</ul></p>
                    <p><strong>Lembretes:</strong><ul>${remindersList}</ul></p>
                    ${imageUrl ? `<img src="${imageUrl}" alt="Imagem do evento" style="max-width:100%;">` : ''}
                `;
                document.getElementById('modalBody').style.borderLeft = `5px solid ${color}`;
                const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                eventModal.show();
            }
        });
        calendar.render();

        document.getElementById('allDayCheckbox').addEventListener('change', function() {
            toggleDateTimeFields(this.checked);
        });

        function toggleDateTimeFields(allDay) {
            const startField = document.getElementById('eventStartDate');
            const endField = document.getElementById('eventEndDate');
            if (allDay) {
                startField.type = 'date';
                endField.type = 'date';
                startField.value = startField.value.split('T')[0];
                endField.value = endField.value.split('T')[0];
            } else {
                startField.type = 'datetime-local';
                endField.type = 'datetime-local';
            }
        }

        document.getElementById('saveEventButton').addEventListener('click', function() {
            const title = document.getElementById('eventTitle').value;
            const description = document.getElementById('eventDescription').value;
            const start = document.getElementById('eventStartDate').value + (document.getElementById('allDayCheckbox').checked ? 'T00:00:00' : '');
            const end = document.getElementById('eventEndDate').value + (document.getElementById('allDayCheckbox').checked ? 'T23:59:59' : '');
            const color = document.getElementById('eventColor').value;

            if (!title || !start || !end) {
                alert("Por favor, preencha o título e as datas do evento.");
                return;
            }

            fetch("{{ route('calendar.createEvent') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    title: title,
                    description: description,
                    start_datetime: start,
                    end_datetime: end,
                    color: color,
                    all_day: document.getElementById('allDayCheckbox').checked
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    calendar.refetchEvents();
                    alert('Evento adicionado com sucesso!');
                    document.getElementById('eventTitle').value = '';
                    document.getElementById('eventDescription').value = '';
                    document.getElementById('eventStartDate').value = '';
                    document.getElementById('eventEndDate').value = '';
                    document.getElementById('eventColor').value = '#3a87ad';
                } else {
                    alert('Erro ao adicionar evento.');
                }
                const createEventModal = bootstrap.Modal.getInstance(document.getElementById('createEventModal'));
                createEventModal.hide();
            })
            .catch(error => console.error('Erro:', error));
        });
    });
</script>
@endpush
