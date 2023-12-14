<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel Users</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="{{ asset('manocss/usercrud.css') }}" rel="stylesheet">
</head>

<body>
    <script>
        $(document).ready(function() {
            // Activate tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Select/Deselect checkboxes
            var checkbox = $('table tbody input[type="checkbox"]');
            $("#selectAll").click(function() {
                if (this.checked) {
                    checkbox.each(function() {
                        this.checked = true;
                    });
                } else {
                    checkbox.each(function() {
                        this.checked = false;
                    });
                }
            });
            checkbox.click(function() {
                if (!this.checked) {
                    $("#selectAll").prop("checked", false);
                }
            });
        });
    </script>
    <x-adminsidebar></x-adminsidebar>

    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-xs-6">
                            <h2>Manage <b>Users</b></h2>
                        </div>
                        <div class="col-xs-6">
                            <button id="deleteSelected" class="btn btn-danger">
                                <i class="material-icons">&#xE15C;</i> <span>Delete Selected</span>
                            </button>
                            <form method="get" action="{{ route('adminpanel') }}">
                                <label for="role">Filter by Role:</label>
                                <select name="role" id="role">
                                    <option value="" {{ request('role') == '' ? 'selected' : '' }}>All</option>
                                    <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Meras</option>
                                    <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>User</option>
                                </select>
                                <br>
                                <label for="email_verified">Email Verification:</label>
                                <select name="email_verified" id="email_verified">
                                    <option value="" {{ request('email_verified') == '' ? 'selected' : '' }}>All
                                    </option>
                                    <option value="verified"
                                        {{ request('email_verified') == 'verified' ? 'selected' : '' }}>Verified
                                    </option>
                                    <option value="not_verified"
                                        {{ request('email_verified') == 'not_verified' ? 'selected' : '' }}>Not Verified
                                    </option>
                                </select>
                                <button type="submit">Apply Filter</button>
                            </form>
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
                            <th>Username</th>
                            <th>Email</th>
                            <th>Is verified</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    @if ($user->role == 2)
                                        <span class="custom-checkbox">
                                            <input type="checkbox" id="checkbox{{ $user->id }}"
                                                class="user-checkbox" name="options[]" value="{{ $user->id }}">
                                            <label for="checkbox{{ $user->id }}"></label>
                                        </span>
                                    @elseif($user->role == 1)
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="glyphicon glyphicon-ok-sign icon-style"></span>
                                    @else
                                        <span class="glyphicon glyphicon-remove-sign icon-style"></span>
                                    @endif
                                </td>
                                <td>{{ $user->role == 1 ? 'Meras' : 'User' }}</td>
                                <td>
                                    @if ($user->role == 2)
                                        <a href="#editOptionsModal{{ $user->id }}" class="edit"
                                            data-toggle="modal">
                                            <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                                        </a>
                                        <a href="#deleteModal{{ $user->id }}" class="delete" data-toggle="modal">
                                            <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i>
                                        </a>
                                    @elseif($user->role == 1)
                                        <a href="#editOptionsModal{{ $user->id }}" class="edit"
                                            data-toggle="modal">
                                            <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <!-- Edit Modal HTML -->
                            <div id="editOptionsModal{{ $user->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Options</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-secondary" data-toggle="modal"
                                                    data-target="#editUsernameModal{{ $user->id }}">Edit
                                                    Username</button>
                                                <button type="button" class="btn btn-secondary" data-toggle="modal"
                                                    data-target="#editEmailModal{{ $user->id }}">Edit
                                                    Email</button>
                                                <button type="button" class="btn btn-secondary" data-toggle="modal"
                                                    data-target="#editRoleModal{{ $user->id }}">Edit Role</button>
                                                <button type="button" class="btn btn-secondary" data-toggle="modal"
                                                    data-target="#editPasswordModal{{ $user->id }}">Edit
                                                    Password</button>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default"
                                                data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Edit Username modal -->
                            <div id="editUsernameModal{{ $user->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST"
                                            action="{{ route('adminpanel.updateUsername', $user->id) }}">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Username</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Current Username</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ $user->name }}" required readonly>
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" name="user_id"
                                                        value="{{ $user->id }}">
                                                    <label>Username</label>
                                                    <input type="text" name="username" class="form-control"
                                                        required>
                                                </div>
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <input type="button" class="btn btn-default" data-dismiss="modal"
                                                    value="Cancel">
                                                <input type="submit" class="btn btn-info" value="Save">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- End --}}
                            {{-- Email modal --}}
                            <div id="editEmailModal{{ $user->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST"
                                            action="{{ route('adminpanel.updateEmail', $user->id) }}">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Email</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="email_verified_at" value="">
                                                <div class="form-group">
                                                    <label>Current Email</label>
                                                    <input type="email" class="form-control"
                                                        value="{{ $user->email }}" required disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        required>
                                                </div>
                                            </div>
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="modal-footer">
                                                <input type="button" class="btn btn-default" data-dismiss="modal"
                                                    value="Cancel">
                                                <input type="submit" class="btn btn-info" value="Save">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- END --}}
                            {{-- Edit Role --}}
                            <div id="editRoleModal{{ $user->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('adminpanel.updateRole', $user->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Role</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <div class="form-group">
                                                    <label for="current_role">Current Role</label>
                                                    <input type="text" class="form-control" id="current_role"
                                                        value="{{ $user->role == 1 ? 'Meras' : 'User' }}" disabled>
                                                </div>
                                                <select id="role" name="role" class="form-control" required>
                                                    <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>
                                                        User</option>
                                                    <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>
                                                        Meras</option>
                                                </select>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="button" class="btn btn-default" data-dismiss="modal"
                                                    value="Cancel">
                                                <input type="submit" class="btn btn-info" value="Save">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- END --}}
                            {{-- Edit Password --}}
                            <div id="editPasswordModal{{ $user->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('adminpanel.updatePassword', $user->id) }}"
                                            method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit Password</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" name="password" class="form-control"
                                                        required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Confirm Password</label>
                                                    <input type="password" name="password_confirmation"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                            @error('password')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="modal-footer">
                                                <input type="button" class="btn btn-default" data-dismiss="modal"
                                                    value="Cancel">
                                                <input type="submit" class="btn btn-info" value="Save">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            {{-- END --}}
                            <!-- Delete Modal HTML -->
                            <div id="deleteModal{{ $user->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.user.delete', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header">
                                                <h4 class="modal-title">Delete User: {{ $user->name }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this user?
                                                </p>
                                                <p class="text-warning"><small>This action cannot be undone.</small>
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="button" class="btn btn-default" data-dismiss="modal"
                                                    value="Cancel">
                                                <input type="submit" class="btn btn-danger" value="Delete">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                @if ($users->hasPages())
                    <div class="clearfix">
                        <div class="hint-text">
                            Showing <b>{{ $users->firstItem() }}</b> to <b>{{ $users->lastItem() }}</b> out of
                            <b>{{ $users->total() }}</b> users.
                        </div>
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($users->onFirstPage())
                                <li class="page-item disabled"><a href="#" class="page-link">Previous</a></li>
                            @else
                                <li class="page-item"><a
                                        href="{{ $users->appends(request()->query())->previousPageUrl() }}"
                                        class="page-link">Previous</a></li>
                            @endif

                            {{-- First Page Link --}}
                            @if ($users->currentPage() > 4)
                                <li class="page-item"><a href="{{ $users->appends(request()->query())->url(1) }}"
                                        class="page-link">1</a>
                                </li>
                            @endif


                            {{-- Pagination Elements --}}
                            @for ($i = max(1, $users->currentPage() - 3); $i <= min($users->lastPage(), $users->currentPage() + 3); $i++)
                                @if ($i == $users->currentPage())
                                    <li class="page-item active"><a href="#"
                                            class="page-link">{{ $i }}</a></li>
                                @else
                                    <li class="page-item"><a
                                            href="{{ $users->appends(request()->query())->url($i) }}"
                                            class="page-link">{{ $i }}</a></li>
                                @endif
                            @endfor

                            {{-- Last Page Link --}}
                            @if ($users->currentPage() < $users->lastPage() - 3)
                                <li class="page-item"><a
                                        href="{{ $users->appends(request()->query())->url($users->lastPage()) }}"
                                        class="page-link">{{ $users->lastPage() }}</a></li>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($users->hasMorePages())
                                <li class="page-item"><a
                                        href="{{ $users->appends(request()->query())->nextPageUrl() }}"
                                        class="page-link">Next</a></li>
                            @else
                                <li class="page-item disabled"><a href="#" class="page-link">Next</a></li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        document.getElementById('deleteSelected').addEventListener('click', function() {
            var isConfirmed = confirm(
                'Are you sure you want to delete the selected users? This action cannot be undone.');

            if (isConfirmed) {
                var checkboxes = document.getElementsByClassName('user-checkbox');
                var selected = [];
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Get all selected users
                for (var i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked) {
                        selected.push(checkboxes[i].value);
                    }
                }

                // Send DELETE request
                fetch('/admin/users/deleteSelected', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        selected: selected
                    })
                }).then(function(response) {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert('Error: ' + response.statusText);
                    }
                });
            }
        });
    </script>
</body>

</html>
