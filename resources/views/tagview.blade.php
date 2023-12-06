<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.17/dist/tailwind.min.css">
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
                                        <button
                                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Create New
                                        </button>
                                    </a>
                                </th>
                            </tr>
                        </thead>
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
                                        <form action="{{ route('admin.prefix.delete', $currentPrefix->id) }}"
                                            method="POST" id="deleteForm{{ $currentPrefix->id }}">
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
                            <!-- More people... -->

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
                        <button class="btn btn-secondary w-100 dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                            aria-expanded="false">
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
                                                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
                                                                <form action="{{ route('admin.tag.delete', $tag->id) }}"
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
                    <button class="btn btn-secondary w-100 dropdown-toggle" type="button" id="dropdownMenuButtonNull"
                        data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                        aria-expanded="false">
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
                                                        <a href="">
                                                            <button id="createButton"
                                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                                Create New
                                                            </button>
                                                        </a>
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
