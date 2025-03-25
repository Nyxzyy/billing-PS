@extends('admin.layout-admin')

@section('title', 'Log Activity')
@section('breadcrumb', 'Log History')

@section('content')
    <div class="max-w-screen-xl mx-auto px-2 md:px-2">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-6">
            <div class="flex flex-col md:flex-row md:justify-end md:items-center gap-2">
                <div class="relative w-full md:w-1/5">
                    <div class="search-container">
                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-[#6D717F]" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" name="searchLogs" id="searchLogs" placeholder="Ketik untuk mencari di tabel"
                            class="text-[#6D717F] text-sm w-full pl-8 py-2 border border-[#c4c4c4] rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <div id="logsTable">
                            @include('Admin.partials.log-table', ['logs' => $logs])
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between mt-4 text-sm text-gray-600">
                    <p id="showing-info">Showing {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} of
                        {{ $logs->total() ?? 0 }}</p>
                    <div id="pagination-container" class="flex space-x-2">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let currentRequest = null;

        $('#searchLogs').on('keyup', function() {
            let query = $(this).val();

            if (currentRequest) {
                currentRequest.abort();
            }

            currentRequest = $.ajax({
                url: "{{ route('admin.logActivity.search') }}",
                type: "GET",
                data: {
                    query: query
                },
                beforeSend: function() {
                    $('#logsTable').addClass('opacity-50');
                },
                success: function(response) {
                    $('#logsTable').html(response.html);
                    $('#pagination-container').html(response.pagination);
                    $('#showing-info').text(
                        `Showing ${response.first_item} - ${response.last_item} of ${response.total}`
                    );
                },
                complete: function() {
                    currentRequest = null;
                    $('#logsTable').removeClass('opacity-50');
                }
            });
        });

        // Handle pagination clicks
        $(document).on('click', '#pagination-container a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            let query = $('#searchLogs').val();

            $.ajax({
                url: "{{ route('admin.logActivity.search') }}",
                data: {
                    query: query,
                    page: page
                },
                success: function(response) {
                    $('#logsTable').html(response.html);
                    $('#pagination-container').html(response.pagination);
                    $('#showing-info').text(
                        `Showing ${response.first_item} - ${response.last_item} of ${response.total}`
                    );
                }
            });
        });
    });
</script>
