<x-app-layout>
    <x-slot name="title">Todo List</x-slot>
    <x-slot name="subtitle">Keep track of your tasks</x-slot>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">My Todos</h5>
            <div class="d-flex gap-2">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTodoModal">
                    <i class="bi bi-plus-lg me-1"></i>Add Todo
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle" id="todoTable">
                    <thead>
                        <tr>
                            <th style="width: 40px">#</th>
                            <th>Task</th>
                            <th style="width: 140px">Status</th>
                            <th style="width: 200px">Created</th>
                            <th style="width: 160px">Due</th>
                            <th style="width: 200px">Completed</th>
                            <th style="width: 140px">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="todoBody">
                        <tr>
                            <td>1</td>
                            <td>Call back hot leads</td>
                            <td><span class="badge bg-warning">In Progress</span></td>
                            <td class="created-at">Today, 10:00 AM</td>
                            <td class="due-at">Today</td>
                            <td class="completed-at">-</td>
                            <td>
                                <button class="btn btn-sm btn-outline-success mark-done"><i class="bi bi-check2"></i> Done</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Send product brochure</td>
                            <td><span class="badge bg-secondary">Pending</span></td>
                            <td class="created-at">Today, 9:30 AM</td>
                            <td class="due-at">Tomorrow</td>
                            <td class="completed-at">-</td>
                            <td>
                                <button class="btn btn-sm btn-outline-success mark-done"><i class="bi bi-check2"></i> Done</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Prepare quotation</td>
                            <td><span class="badge bg-success">Completed</span></td>
                            <td class="created-at">Yesterday, 4:10 PM</td>
                            <td class="due-at">-</td>
                            <td class="completed-at">Today, 8:45 AM</td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary" disabled><i class="bi bi-check2"></i> Done</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Todo Modal -->
    <div class="modal fade" id="addTodoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addTodoForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Todo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modalTask" class="form-label">Task</label>
                            <input type="text" id="modalTask" class="form-control" placeholder="Describe the task" required>
                        </div>
                        <div class="mb-3">
                            <label for="modalDue" class="form-label">Due Date</label>
                            <input type="date" id="modalDue" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        (function(){
            const body = document.getElementById('todoBody');
            const addForm = document.getElementById('addTodoForm');
            const modalTask = document.getElementById('modalTask');
            const modalDue = document.getElementById('modalDue');
            const addTodoModal = document.getElementById('addTodoModal');

            function renumberRows() {
                Array.from(body.querySelectorAll('tr')).forEach((tr, idx) => {
                    const first = tr.querySelector('td');
                    if (first) first.textContent = idx + 1;
                });
            }

            function createRow(taskText, dueText) {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td></td>
                    <td>${taskText}</td>
                    <td><span class="badge bg-secondary">Pending</span></td>
                    <td class="created-at">${new Date().toLocaleString()}</td>
                    <td class="due-at">${dueText || '-'}</td>
                    <td class="completed-at">-</td>
                    <td>
                        <button class="btn btn-sm btn-outline-success mark-done"><i class="bi bi-check2"></i> Done</button>
                    </td>
                `;
                return tr;
            }

            if (addForm) {
                addForm.addEventListener('submit', function(e){
                    e.preventDefault();
                    const task = (modalTask.value || '').trim();
                    const dueValue = modalDue.value ? new Date(modalDue.value).toLocaleDateString() : '-';
                    if (!task) {
                        modalTask.focus();
                        return;
                    }
                    const row = createRow(task, dueValue);
                    body.appendChild(row);
                    renumberRows();
                    // reset and close modal
                    modalTask.value = '';
                    modalDue.value = '';
                    const modalInstance = bootstrap.Modal.getOrCreateInstance(addTodoModal);
                    modalInstance.hide();
                });
            }

            body.addEventListener('click', function(e){
                const btn = e.target.closest('.mark-done');
                if (!btn) return;
                const tr = btn.closest('tr');
                const badge = tr.querySelector('.badge');
                if (badge) {
                    badge.className = 'badge bg-success';
                    badge.textContent = 'Completed';
                }
                const dueCell = tr.querySelector('.due-at');
                const completedCell = tr.querySelector('.completed-at');
                if (dueCell) dueCell.textContent = '-';
                if (completedCell) completedCell.textContent = new Date().toLocaleString();
                btn.classList.remove('btn-outline-success');
                btn.classList.add('btn-outline-secondary');
                btn.setAttribute('disabled', 'disabled');
            });
        })();
    </script>
    @endpush
</x-app-layout>


