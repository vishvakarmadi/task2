@extends('layouts.app')
@section('title', 'Journal Entries - Inventory System')
@section('content')
<div class="d-flex align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1"><i class="fas fa-book me-2" style="color:var(--primary)"></i>Accounting Journal Entries</h4>
        <p class="text-muted mb-0">All double-entry bookkeeping records</p>
    </div>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Account</th>
                    <th>Description</th>
                    <th>Debit (TK)</th>
                    <th>Credit (TK)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entries as $entry)
                <tr>
                    <td>{{ $entry->id }}</td>
                    <td>{{ $entry->date->format('d/m/Y') }}</td>
                    <td class="fw-semibold">{{ $entry->account }}</td>
                    <td class="text-muted">{{ $entry->description }}</td>
                    <td class="text-success fw-bold">{{ $entry->debit > 0 ? number_format($entry->debit, 2) : '-' }}</td>
                    <td class="text-danger fw-bold">{{ $entry->credit > 0 ? number_format($entry->credit, 2) : '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No journal entries yet</td></tr>
                @endforelse
            </tbody>
            @if($entries->count() > 0)
            <tfoot class="table-light">
                <tr class="fw-bold">
                    <td colspan="4">Totals</td>
                    <td class="text-success">{{ number_format($entries->sum('debit'), 2) }}</td>
                    <td class="text-danger">{{ number_format($entries->sum('credit'), 2) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
