
<x-app-layout>


@section('page-title', $employee->name)

<livewire:employees.edit  :employee="$employee"/>


</x-app-layout>
