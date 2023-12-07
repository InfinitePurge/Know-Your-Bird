<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('manocss/tagview.css') }}" rel="stylesheet">
</head>

<style>
    .dropdown-menu {
        position: absolute;
        top: 100%;
        /* Always position the dropdown menu below the button */
    }

    .container {
        overflow: visible;
        /* Let the dropdown extend outside the container */
    }
</style>


<body>

    <div class="flex justify-center">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tag
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Options
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="">
                                        <button id="createNewBtn"
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Create New
                                        </button>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        {{-- <div id="createNewModal" class="modal">
                            <div class="modal-content">
                                <span id="closeModalSpan" class="close" onclick="closeModal()">&times;</span>
                                <form action="{{ route('admin.prefix.add') }}" method="POST">
                                    @csrf
                                    <label for="prefixName">Prefix Name:</label>
                                    <input type="text" id="prefixName" name="prefixName" required>
                                    <button type="button" onclick="closeModal()">Cancel</button>
                                    <button type="submit">Submit</button>
                                </form>
                            </div>
                        </div> --}}
                        <div id="createNewModal" class="modal">
                            <div class="login-box">
                                <form action="{{ route('admin.prefix.add') }}" method="POST">
                                    @csrf
                                    <h2 for="prefixName">Prefix Name:</h2>
                                    <form>
                                        <div class="user-box">
                                            <input type="text" id="prefixName" name="prefixName" required
                                                placeholder="Input Prefix Name">
                                        </div>
                                        <div class="button-container">
                                            <button class="button-style btn" type="button" onclick="closeModal()">
                                                Cancel
                                            </button>
                                            <button class="button-style btn" type="submit">
                                                Submit
                                            </button>
                                        </div>
                                    </form>
                            </div>
                        </div>
                </div>

                <script>
                    var modal = document.getElementById('createNewModal');
                    var createNewBtn = document.getElementById('createNewBtn');
                    var closeModalSpan = document.getElementById('closeModalSpan');
                    var form = document.getElementById('prefixForm');

                    createNewBtn.onclick = function(event) {
                        event.preventDefault();
                        modal.style.display = 'block';
                    }

                    closeModalSpan.onclick = function() {
                        modal.style.display = 'none';
                    }

                    window.onclick = function(event) {
                        if (event.target == modal) {
                            modal.style.display = 'none';
                        }
                    }

                    form.onsubmit = function(event) {
                        event.preventDefault();
                        closeModal();
                    }
                </script>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($prefix as $currentPrefix)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $currentPrefix->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $currentPrefix->prefix }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="" class="text-yellow-500 hover:text-yellow-800 mx-5">Edit</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                <form action="{{ route('admin.prefix.delete', $currentPrefix->id) }}" method="POST"
                                    id="deleteForm{{ $currentPrefix->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <a href="#" class="text-red-500 hover:text-red-800 mx-5"
                                        onclick="deletePrefix({{ $currentPrefix->id }})">Delete</a>
                                </form>

                                <script>
                                    function deletePrefix(prefixId) {
                                        if (confirm('Are you sure you want to delete this prefix?')) {
                                            document.getElementById('deleteForm' + prefixId).submit();
                                        }
                                    }
                                </script>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="dropdown-center" id="myDropdown">
                    @foreach ($prefix as $prefixItem)
                        <button class="btn btn-secondary w-100 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false"
                            data-prefix-id="{{ $prefixItem->id }}">
                            {{ $prefixItem->prefix }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <div class="flex justify-center">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                            <table class="w-full divide-y divide-gray-200">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            ID
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Tag
                                                        </th>
                                                        <th scope="col"
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            Options
                                                        </th>
                                                        <th
                                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                            <a href="">
                                                                <button id="createNewBtn"
                                                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                                    data-prefix-id="{{ $prefixItem->id }}">
                                                                    Create New
                                                                </button>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white divide-y divide-gray-200">
                                                    @foreach ($prefixItem->tags as $tag)
                                                        <tr>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="flex items-center">
                                                                    <div class="ml-4">
                                                                        <div class="text-sm font-medium text-gray-900">
                                                                            {{ $tag->id }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm text-gray-900">{{ $tag->name }}
                                                                </div>
                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                                <a href=""
                                                                    class="text-yellow-500 hover:text-yellow-800 mx-5">Edit</a>

                                                            </td>
                                                            <td
                                                                class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                                                <form
                                                                    action="{{ route('admin.tag.delete', $tag->id) }}"
                                                                    method="POST"
                                                                    id="deleteTagForm{{ $tag->id }}">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button"
                                                                        onclick="deleteTag({{ $tag->id }})"
                                                                        class="text-red-500 hover:text-red-800 mx-5">Delete</button>
                                                                </form>

                                                                <script>
                                                                    function deleteTag(tagId) {
                                                                        if (confirm('Are you sure you want to delete this tag?')) {
                                                                            document.getElementById('deleteTagForm' + tagId).submit();
                                                                        }
                                                                    }
                                                                </script>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- <div id="createTagForm" class="hidden">
                        <form action="{{ route('admin.tag.add.prefix') }}" method="post">
                            @csrf
                            <!-- Hidden field for prefix ID -->
                            <input type="hidden" name="prefixId" id="prefixIdInput">
                            <input type="text" name="tagName" placeholder="Enter Tag Name" required>
                            <button type="submit">Add Tag with prefix</button>
                        </form>
                    </div> --}}
                    <div id="createTagForm" class="hidden">
                        <div class="login-box">
                            <form action="{{ route('admin.tag.add.prefix') }}" method="post">
                                @csrf
                                <h2 for="prefixName">Tag Name:</h2>
                                <form>
                                    <div class="user-box">
                                        <input type="hidden" name="prefixId" id="prefixIdInput">
                                        <input type="text" name="tagName" placeholder="Enter Tag Name" required>
                                    </div>
                                    <div class="button-container">
                                        <button class="button-style btn" type="button" onclick="closeModal()">
                                            Cancel
                                        </button>
                                        <button class="button-style btn" type="submit">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                        </div>
                    </div>

                    <script>
                        function openCreateTagForm(prefixId) {
                            document.getElementById('prefixIdInput').value = prefixId;
                            document.getElementById('createTagForm').style.display = 'block';
                        }

                        document.querySelectorAll('#createNewBtn').forEach(button => {
                            button.addEventListener('click', function(event) {
                                event.preventDefault();
                                const prefixId = this.dataset.prefixId;
                                console.log(prefixId);
                                openCreateTagForm(prefixId);
                            });

                            button.addEventListener('click', function(event) {
                                event.preventDefault();
                                event.stopPropagation();
                                const prefixId = this.dataset.prefixId;
                                openCreateTagForm(prefixId);
                            });

                            document.querySelectorAll('.createNewBtn').forEach(button => {});
                        });
                    </script>






                    <button class="btn btn-secondary w-100 dropdown-toggle" type="button"
                        id="dropdownMenuButtonNull" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                        aria-haspopup="true" aria-expanded="false">
                        Null Prefix
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <div class="flex justify-center">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        ID
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Tag
                                                    </th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Options
                                                    </th>
                                                    <th
                                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        <button id="createButton"
                                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                            onclick="openCreateModal()">Create New</button>

                                                        {{-- <div id="createTagModal" class="hidden">
                                                            <form action="/admin/tag/add" method="post">
                                                                @csrf <!-- Include CSRF Token -->
                                                                <input type="text" name="tagName"
                                                                    placeholder="Enter Tag Name" required>
                                                                <button type="submit">Add Tag no prefix</button>
                                                            </form>
                                                        </div> --}}
                                                        <div id="createTagModal" class="hidden">
                                                            <div class="login-box">
                                                            
                                                                <form action="/admin/tag/add" method="post">
                                                                    @csrf
                                                                    <h2 for="prefixName">Null Tag Name:</h2>
                                                                    <form>
                                                                        <div class="user-box">
                                                                            <input type="text" name="tagName"
                                                                    placeholder="Enter Tag Name" required>
                                                                        </div>
                                                                        <div class="button-container">
                                                                            <button class="button-style btn"
                                                                                type="button" onclick="closeModal()">
                                                                                Cancel
                                                                            </button>
                                                                            <button class="button-style btn"
                                                                                type="submit">
                                                                                Submit
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                            </div>
                                                        </div>
                                    </div>
                                    <script>
                                        function openCreateModal() {
                                            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                            document.querySelector('#createTagModal form').innerHTML += '<input type="hidden" name="_token" value="' +
                                                csrfToken + '">';
                                            document.getElementById('createTagModal').style.display = 'block';
                                        }
                                    </script>
                                    </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($tags as $tag)
                                            @if ($tag->prefix_id === null)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $tag->id }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $tag->name }}
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <a href=""
                                                            class="text-yellow-500 hover:text-yellow-800 mx-5">Edit</a>

                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">

                                                        <a href=""
                                                            class="text-red-500 hover:text-red-800 mx-5">Delete</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('jasonas/tagview.js') }}"></script>

</body>

</html>
