@extends('layouts.app')
@section('title', 'Journal Entries')
@section('content')
<h4 class="mb-3">Journal Entries</h4>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-sm mb-0">
            <thead>
                <tr><th>Date</th><th>Account</th><th>Description</th><th>Debit</th><th>Credit</th></tr>
            </thead>
            <tbody>
                @forelse($entries as $entry)
                <tr>
                    <td>{{ $entry->date->format('d/m/Y') }}</td>
                    <td><strong>{{ $entry->account }}</strong></td>
                    <td class="text-muted">{{ $entry->description }}</td>
                    <td class="text-success">{{ $entry->debit > 0 ? number_format($entry->debit, 2) : '' }}</td>
                    <td class="text-danger">{{ $entry->credit > 0 ? number_format($entry->credit, 2) : '' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-3">No journal entries</td></tr>
                @endforelse
            </tbody>
            @if($entries->count())
            <tfoot class="table-light">
                <tr>
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td class="text-success"><strong>{{ number_format($entries->sum('debit'), 2) }}</strong></td>
                    <td class="text-danger"><strong>{{ number_format($entries->sum('credit'), 2) }}</strong></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection
