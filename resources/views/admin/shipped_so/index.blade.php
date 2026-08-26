@extends('layouts.admin')

@section('header-title', 'Special Order')

@section('content')

@vite(['resources/css/admin/shipped_so/shipped_so.css'])


<div class="page">

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="success-alert" id="successAlert">

            <i class="fas fa-circle-check"></i>

            <span>
                {{ session('success') }}
            </span>

            <button
                type="button"
                class="success-close"
                onclick="closeSuccessAlert()">
                &times;
            </button>

        </div>
    @endif

    <div class="page-header">

        <h2><i class="fas fa-ship"></i>
            Special Order
        </h2>

    <button class="btn-add" onclick="openCreateModal()">
    <i class="fas fa-plus"></i>
    New Record
</button>

    </div>

    <div class="stats">

        <div class="stat-card blue">

            <div>
                <h2>{{ $total }}</h2>
                <p>Total Records</p>
            </div>

            <div class="stat-icon">
                <i class="fas fa-ship"></i>
            </div>

        </div>


        <div class="stat-card gray">

            <div>
                <h2>{{ $pending }}</h2>
                <p>Pending</p>
            </div>

            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>

        </div>

    <div class="stat-card orange">

        <div>
            <h2>{{ $endorsement }}</h2>
            <p>For Endorsement</p>
        </div>

        <div class="stat-icon">
            <i class="fas fa-paper-plane"></i>
        </div>

    </div>

    <div class="stat-card green">

        <div>
            <h2>{{ $completed }}</h2>
            <p>Completed</p>
        </div>

        <div class="stat-icon">
            <i class="fas fa-circle-check"></i>
        </div>

    </div>

</div>

<div class="filter-card">

    <form id="filterForm" method="GET" action="{{ route('admin.shipped-so.index') }}">

        <div class="filter-grid">
            <div>
                <select name="course" id="courseFilter">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course }}"
                            {{ request('course') == $course ? 'selected' : '' }}>
                            {{ $course }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="batch" id="batchFilter">
                    <option value="">All Batches</option>
                    @foreach($batches as $batch)
                        <option value="{{ $batch->id }}"
                            {{ request('batch') == $batch->id ? 'selected' : '' }}>
                            {{ $batch->batch_year }}
                        </option>
                    @endforeach
                </select>
            </div>

<div class="search-box">

    <i class="fas fa-search"></i>

    <input
        type="text"
        id="searchFilter"
        name="search"
        placeholder="Search cadet..."
        value="{{ request('search') }}">

</div>

        </div>
    </form>

</div>

    <div class="card">

        <table>

            <thead>

                <tr>

                    <th>Cadet</th>

                    <th>Deliberation Date</th>

                    <th>Status</th>

                    <th>OBT Endorsement</th>

                    <th>CHED SO Number</th>

                    <th>Date Issued</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

            @forelse($orders as $order)

                <tr>

                    <td>{{ $order->cadet->full_name ?? '-' }}</td>

                    <td>{{ optional($order->deliberation_date)->format('M d, Y') }}</td>

                    <td>

                        @php

                            $class='pending';

                            if($order->status=='For Deliberation') $class='deliberation';

                            elseif($order->status=='For Endorsement') $class='endorsement';

                            elseif($order->status=='Shipped') $class='shipped';

                            elseif($order->status=='Completed') $class='completed';

                        @endphp

                        <span class="badge {{ $class }}">
                            {{ $order->status }}
                        </span>

                    </td>

                    <td>{{ optional($order->obt_endorsement_date)->format('M d, Y') }}</td>

                    <td>{{ $order->so_number ?? '-' }}</td>

                    <td>{{ optional($order->so_date_issued)->format('M d, Y') }}</td>

                    <td>

                    <button
                        type="button"
                        class="btn-edit"
                        onclick="editRecord({{ $order->id }})">
                        Edit
                    </button>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7">
                        No records found.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

<div id="createModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">

            <h3 id="modalTitle">Create Special Order</h3>

            <span class="close" onclick="closeCreateModal()">&times;</span>

        </div>

        <form id="orderForm"
      action="{{ route('admin.shipped-so.store') }}"
      method="POST">

    @csrf

    <input type="hidden" id="methodField" name="_method" value="POST">

        <div class="form-group">

            <label>Cadet</label>

            <select name="cadet_id" id="cadet_id" required>

                <option value="">Select Cadet</option>

                @foreach($cadets as $cadet)

                    <option value="{{ $cadet->id }}">
                        {{ $cadet->full_name }}
                    </option>

                @endforeach

            </select>

            {{-- Used only when editing because disabled fields are not submitted --}}
            <input type="hidden" name="edit_cadet_id" id="edit_cadet_id">

        </div>

            <div class="form-group">

                <label>Deliberation Date</label>

                <input type="date"
                       name="deliberation_date">

            </div>

            <div class="form-group">

            <label>Deliberation Status</label>

                <select name="status" id="status" required>
                    <option value="Pending">Pending</option>
                    <option value="For Deliberation">For Deliberation</option>
                    <option value="For Endorsement">For Endorsement</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Completed">Completed</option>
                </select>

            </div>

            <div class="form-group">

                <label>OBT Endorsement Date</label>

                <input type="date"
                       name="obt_endorsement_date">

            </div>

            <div class="form-group">

                <label>CHED SO Number</label>

                <input type="text"
                       name="so_number">

            </div>

            <div class="form-group">

                <label>Date Issued</label>

                <input type="date"
                    name="so_date_issued">

            </div>

            <div class="form-group">

                <label>Remarks</label>

                <textarea name="remarks"></textarea>

            </div>

            <div class="modal-footer">

                <button
                    class="btn-add"
                    type="submit"
                    id="submitBtn">
                    Save Record
                </button>

            </div>

        </form>

    </div>

</div>
<script>
const filterForm = document.getElementById('filterForm');
const courseFilter = document.getElementById('courseFilter');
const batchFilter = document.getElementById('batchFilter');
const searchFilter = document.getElementById('searchFilter');

courseFilter.addEventListener('change', function () {
    filterForm.submit();
});

batchFilter.addEventListener('change', function () {
    filterForm.submit();
});

let searchTimer;

searchFilter.addEventListener('keyup', function () {

    clearTimeout(searchTimer);

    searchTimer = setTimeout(function () {
        filterForm.submit();
    }, 500);

});
</script>

<script>

function openCreateModal() {

    const modal = document.getElementById('createModal');
    const form = document.getElementById('orderForm');
    const methodField = document.getElementById('methodField');
    const cadetSelect = document.getElementById('cadet_id');
    const hiddenCadet = document.getElementById('edit_cadet_id');

    form.reset();

    form.action = "{{ route('admin.shipped-so.store') }}";

    methodField.disabled = true;
    methodField.value = "POST";

    cadetSelect.disabled = false;
    hiddenCadet.value = "";

    document.getElementById('modalTitle').textContent =
        'Create Special Order';

    document.getElementById('submitBtn').textContent =
        'Save Record';


    modal.style.display = 'block';
}


function closeCreateModal() {

    document.getElementById('createModal').style.display = 'none';

}


function editRecord(id) {

    fetch(`/admin/shipped-so/${id}/edit`)
        .then(response => {

            if (!response.ok) {
                throw new Error('Failed to load record.');
            }

            return response.json();

        })
        .then(data => {

            const modal = document.getElementById('createModal');
            const form = document.getElementById('orderForm');

            const cadetSelect =
                document.getElementById('cadet_id');

            const hiddenCadet =
                document.getElementById('edit_cadet_id');

            const methodField =
                document.getElementById('methodField');

            form.action = `/admin/shipped-so/${id}`;

            methodField.disabled = false;
            methodField.value = 'PUT';


            let existingOption =
                cadetSelect.querySelector(
                    `option[value="${data.cadet_id}"]`
                );

            if (!existingOption && data.cadet) {

                existingOption =
                    document.createElement('option');

                existingOption.value = data.cadet_id;

                existingOption.textContent =
                    data.cadet.full_name;

                cadetSelect.appendChild(existingOption);

            }

            cadetSelect.value = data.cadet_id;

            cadetSelect.disabled = true;

            hiddenCadet.value = data.cadet_id;

            document.querySelector(
                '[name="deliberation_date"]'
            ).value =
                data.deliberation_date
                    ? data.deliberation_date.substring(0, 10)
                    : '';


            document.querySelector(
                '[name="obt_endorsement_date"]'
            ).value =
                data.obt_endorsement_date
                    ? data.obt_endorsement_date.substring(0, 10)
                    : '';


            document.querySelector(
                '[name="so_number"]'
            ).value =
                data.so_number ?? '';


            document.querySelector(
                '[name="so_date_issued"]'
            ).value =
                data.so_date_issued
                    ? data.so_date_issued.substring(0, 10)
                    : '';


            document.querySelector(
                '[name="status"]'
            ).value =
                data.status;


            document.querySelector(
                '[name="remarks"]'
            ).value =
                data.remarks ?? '';


            document.getElementById('modalTitle').textContent =
                'Edit Special Order';

            document.getElementById('submitBtn').textContent =
                'Update Record';


            modal.style.display = 'block';

        })
        .catch(error => {

            console.error(error);

            alert(
                'Unable to load the Special Order record.'
            );

        });

}


window.addEventListener('click', function(event) {

    const modal =
        document.getElementById('createModal');

    if (event.target === modal) {

        closeCreateModal();

    }

});

document.addEventListener('keydown', function(event) {

    if (event.key === 'Escape') {

        closeCreateModal();

    }

});

function closeSuccessAlert() {
    const alert = document.getElementById('successAlert');

    if (alert) {
        alert.remove();
    }
}

document.addEventListener('DOMContentLoaded', function () {

    const alert = document.getElementById('successAlert');

    if (alert) {

        setTimeout(function () {

            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            alert.style.transition = '0.3s ease';

            setTimeout(function () {
                alert.remove();
            }, 300);

        }, 4000);
    }

});

</script>

@endsection