
<x-app-layout>


@section('page-title', $employee->name)

<livewire:employees.show  :employee="$employee"/>


</x-app-layout>
