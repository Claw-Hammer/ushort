<div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <div class="flex flex-row mb-3.5">
                    <button wire:click="$set('showAddUrl', true)" type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        Add URL
                    </button>
                </div>

                <div class="overflow-hidden border-b border-gray-200 shadow sm:rounded-lg">
                    @if(count($urlData))
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Real Url
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Short Url
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Number of Visits
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
                                    Safe Link for Work?
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($urlData as $data)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $data->real_url }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="text-sm text-gray-900 hover:text-indigo-600 hover:font-bold">
                                            <a href="{{ $data->short_url }}" target="_blank">
                                                {{ $data->short_url }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="text-sm text-gray-900">{{ $data->number_of_visits }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($data->nsfw == 0)
                                            <div class="text-sm text-gray-900">Yes</div>
                                        @else
                                            <div class="text-sm text-red-600">No</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="px-4 py-3 text-gray-500 bg-white border-t border-gray-200 sm:px-6">
                            There are no Urls yet
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <x-jet-dialog-modal wire:model="showAddUrl">

        <x-slot name="title">
            <h2 class="text-gray-600 text-center">ADD URL</h2>
            <x-jet-section-border></x-jet-section-border>
        </x-slot>

        <x-slot name="content">

            <form class="space-y-8 divide-y divide-gray-200">
                <div class="space-y-8 divide-y divide-gray-200">
                    <div>
                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            @csrf
                            <div class="sm:col-span-3">
                                <label for="real_url" class="block text-sm font-medium text-gray-700">
                                    URL
                                </label>
                                @error("real_url")
                                <small class="text-red-600">* {{ $message }}</small>
                                @enderror
                                <div class="mt-1">
                                    <input type="text" name="real_url" id="real_url" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" wire:model.defer="real_url" required>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="short_url" class="block text-sm font-medium text-gray-700">
                                    Short URL
                                </label>
                                <div class="mt-1">
                                    <input type="text" name="short_url" id="short_url" autocomplete="family-name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" wire:model="short_url" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pt-5">
                    <div class="flex justify-end">
                        <button wire:click="clear" type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Close
                        </button>
                        @if($this->short_url == '')
                            <button type="button" wire:click="save" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                            </button>
                        @else
                            <button type="button" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-black bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-700" disabled>
                                Url Saved
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </x-slot>

        <x-slot name="footer">

        </x-slot>

    </x-jet-dialog-modal>
</div>
