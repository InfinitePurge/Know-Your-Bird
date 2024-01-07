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

<body>
    <x-adminsidebar></x-adminsidebar>
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2>Manage <b>Prefixes</b></h2>
                            <div class="btn-group">
                            <a id="createNewBtnn" class="btn btn-success" data-toggle="modal">
                                <span>Create New</span>
                            </a>
                            <button id="" class="btn btn-danger">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <th>ID</th>
                            <th>Tag</th>
                            <th>Date created</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prefix as $currentPrefix)
                            <tr>
                                <td>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="checkbox{{ $currentPrefix->id }}" name="options[]"
                                            value="{{ $currentPrefix->id }}">
                                        <label for="checkbox{{ $currentPrefix->id }}"></label>
                                    </span>
                                </td>
                                <td>{{ $currentPrefix->id }}</td>
                                <td>{{ $currentPrefix->prefix }}</td>
                                <td>{{ $currentPrefix->created_at }}</td>
                                <td class="edit">
                                    <div class="flex items-center">
                                        <a href="#" class="text-yellow-500 hover:text-yellow-800"
                                            onclick="openPrefixEditForm({{ $currentPrefix->id }}, '{{ $currentPrefix->prefix }}')">Edit</a>


                                        <form action="{{ route('admin.prefix.delete', $currentPrefix->id) }}"
                                            method="POST" id="deleteForm{{ $currentPrefix->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <a href="#" class="text-red-500 hover:text-red-800 mx-5"
                                                onclick="deletePrefix({{ $currentPrefix->id }})">Delete</a>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div id="createNewModal" class="modal">
        <div class="login-box">
            <form action="{{ route('admin.prefix.add') }}" method="POST">
                @csrf
                <h2 for="prefixName">Prefix Name:</h2>
                <form>
                    <div class="user-box">
                        <input type="text" id="prefixName" name="prefixName" required placeholder="Input Prefix Name"
                            maxlength="30">
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
    </div>
    <script>
        function closeModal() {
            var modal = document.getElementById('createNewModal');
            modal.style.display = 'none';
        }
    </script>

    <script>
        var modal = document.getElementById('createNewModal');
        var createNewBtn = document.getElementById('createNewBtnn');
        var closeModalSpan = document.getElementById('closeModalSpan');
        var form = document.getElementById('prefixForm');

        createNewBtnn.onclick = function(event) {
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










    @foreach ($prefix as $prefixItem)
        <div class="container">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-xs-6">
                                <h2>Manage {{ $prefixItem->prefix }}</h2>
                                <div class="btn-group">
                                <a href="">
                                    <button id="createNewBtn" class="btn btn-success"
                                        data-prefix-id="{{ $prefixItem->id }}">
                                        Create New
                                    </button>
                                </a>
                                <button id="" class="btn btn-danger">
                                    Delete
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="selectAll">
                                        <label for="selectAll"></label>
                                    </span>
                                </th>
                                <th>ID</th>
                                <th>Tag</th>
                                <th>Date created</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prefixItem->tags as $tag)
                                <tr>
                                    <td>
                                        <span class="custom-checkbox">
                                            <input type="checkbox" id="checkbox{{ $currentPrefix->id }}"
                                                name="options[]" value="{{ $currentPrefix->id }}">
                                            <label for="checkbox{{ $currentPrefix->id }}"></label>
                                        </span>
                                    </td>
                                    <td>{{ $tag->id }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td></td>
                                    <td class="edit">
                                        <div class="flex items-center">
                                            <a href="#" class="text-yellow-500 hover:text-yellow-800 mx-5"
                                                onclick="openEditForm({{ $tag->id }})">Edit</a>

                                            <form action="{{ route('admin.tag.delete', $tag->id) }}" method="POST"
                                                id="deleteTagForm{{ $tag->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="deleteTag({{ $tag->id }})"
                                                    class="text-red-500 hover:text-red-800 mx-5">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach

    <div id="createTagForm" class="modal">
        <div class="login-box">
            <form action="{{ route('admin.tag.add.prefix') }}" method="post">
                @csrf
                <h2 for="prefixName">Tag Name:</h2>
                <div class="user-box">
                    <input type="hidden" name="prefixId" id="prefixIdInput">
                    <input type="text" name="tagName" placeholder="Enter Tag Name" required maxlength="30">
                </div>
                <div class="button-container">
                    <button class="button-style btn" type="button" onclick="closeTagForm()">Cancel</button>
                    <button class="button-style btn" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function closeTagForm() {
            var tagForm = document.getElementById('createTagForm');
            tagForm.style.display = 'none';
        }
    </script>

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





    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2>Null Prefixes</h2>
                            <div class="btn-group">
                                <button id="createButton" class="btn btn-success" onclick="openCreateModal()">
                                    Create New
                                </button>
                                <button id="" class="btn btn-danger">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <span class="custom-checkbox">
                                    <input type="checkbox" id="selectAll">
                                    <label for="selectAll"></label>
                                </span>
                            </th>
                            <th>ID</th>
                            <th>Tag</th>
                            <th>Date created</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $tag)
                            @if ($tag->prefix_id === null)
                                <tr>
                                    <td>
                                        <span class="custom-checkbox">
                                            <input type="checkbox" id="checkbox{{ $currentPrefix->id }}"
                                                name="options[]" value="{{ $currentPrefix->id }}">
                                            <label for="checkbox{{ $currentPrefix->id }}"></label>
                                        </span>
                                    </td>
                                    <td>{{ $tag->id }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td></td>
                                    <td class="edit">
                                        <div class="flex items-center">
                                            <a href="#" class="text-yellow-500 hover:text-yellow-800 mx-5"
                                                onclick="openEditForm({{ $tag->id }})">Edit</a>

                                            <form action="{{ route('admin.tag.delete', $tag->id) }}" method="POST"
                                                id="deleteTagForm{{ $tag->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="deleteTag({{ $tag->id }})"
                                                    class="text-red-500 hover:text-red-800 mx-5">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="createTagModal" class="hidden">
        <div class="login-box">
            <form action="/admin/tag/add" method="post" id="createTagForm">
                @csrf
                <h2 for="prefixName">Null Tag Name:</h2>
                <div class="user-box">
                    <input type="text" name="tagName" placeholder="Enter Tag Name" required maxlength="30">
                </div>
                <div class="button-container">
                    <button class="button-style btn" type="button" onclick="closeTagModal()">
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
        function closeTagModal() {
            var tagForm = document.getElementById('createTagModal');
            tagForm.style.display = 'none';
        }
    </script>

    <script>
        function openCreateModal() {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var createTagModal = document.getElementById('createTagModal');

            // Add CSRF token to the form
            document.querySelector('#createTagForm').innerHTML += '<input type="hidden" name="_token" value="' + csrfToken +
                '">';

            // Set the display property to block
            createTagModal.style.display = 'block';

            // Set the position to fixed
            createTagModal.style.position = 'fixed';
            createTagModal.style.top = '50%';
            createTagModal.style.left = '50%';
            createTagModal.style.transform = 'translate(-50%, -50%)';
        }
    </script>


    @foreach ($prefix as $currentPrefix)
        <div id="editPrefixForm{{ $currentPrefix->id }}" class="hidden">
            <div class="login-box">
                <form action="{{ route('admin.prefix.update', ['id' => $currentPrefix->id]) }}" method="POST"
                    id="editForm{{ $currentPrefix->id }}">
                    @csrf
                    @method('PUT')
                    <h2>Edit Prefix</h2>
                    <div class="user-box">
                        <input type="text" id="editPrefixName{{ $currentPrefix->id }}" name="editPrefixName"
                            required placeholder="Enter Prefix Name" maxlength="30"
                            value="{{ $currentPrefix->prefix }}">
                    </div>
                    <div class="button-container">
                        <button class="button-style btn" type="reset"
                            onclick="closePrefixForm({{ $currentPrefix->id }})">
                            Cancel
                        </button>
                        <button class="button-style btn" type="submit">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach



    {{-- Forma Edit Tag ir Null --}}
    @foreach ($tags as $tag)
        <div id="editTagForm{{ $tag->id }}" class="hidden login-box">
            <form action="{{ route('admin.tag.update', ['id' => $tag->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <h2>Edit Tag:<br>{{ optional($tag->prefix)->prefix ?? 'No Prefix' }} - {{ $tag->name }}</h2>
                <select id="prefixOptions{{ $tag->id }}" name="prefix_id">
                    <option value="">No Prefix</option>
                    @foreach ($prefix as $prefixes)
                        <option value="{{ $prefixes->id }}" {{ $tag->prefix_id == $prefixes->id ? 'selected' : '' }}>
                            {{ $prefixes->prefix }}
                        </option>
                    @endforeach
                </select>

                <div class="user-box">
                    <input type="text" id="editTagName{{ $tag->id }}" name="name" required
                        placeholder="Enter Tag Name" value="{{ $tag->name }}">
                </div>

                <div class="button-container">
                    <button class="button-style btn" type="button"
                        onclick="closeEditForm({{ $tag->id }})">Cancel</button>
                    <button class="button-style btn" type="submit">Save</button>
                </div>
            </form>
        </div>
    @endforeach
    {{-- Pabaiga edit formai Tag --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('jasonas/tagview.js') }}"></script>

</body>

</html>
