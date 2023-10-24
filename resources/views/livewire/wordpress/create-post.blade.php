<div class="space-y-4">
    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Create a new post</h1>
    <div>
        <form class="space-y-4" wire:submit="ask">
            <label for="website" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Propose your
                topic</label>
            <input wire:model='topic' type="text" id="topic"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Write a post for the benefits that bees are bringing to the environment..." required>
            <div class="flex justify-end">
                <button wire:loading.remove wire:target="ask"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Propose a Wordpress Post
                </button>
                <div wire:loading wire:target="ask"
                    class="flex items-center justify-center borderrounded-lg dark:bg-gray-800 dark:border-gray-700">
                    <div role="status">
                        <svg aria-hidden="true"
                            class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </form>
        @if ($messages)
            <div class="mt-4 space-y-2">
                <div class="mt-2 w-full">
                    <label for="title" class=" block mb-2 text-sm font-medium text-gray-900 dark:text-white">Blog
                        Url</label>
                    <input type="text" id="title" wire:model='url'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="https:://www.example.com" required>
                </div>
                <div class="mt-2 w-full">
                    <label for="title" class=" block mb-2 text-sm font-medium text-gray-900 dark:text-white">Post
                        Title</label>
                    <input type="text" id="title" wire:model='title'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Write a post for the benefits that bees are bringing to the environment..."
                        required>
                </div>
                <div class="mt-2">
                    <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Post
                        Body</label>
                    <textarea rows="10" wire:model='body'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Write a post for the benefits that bees are bringing to the environment..." required>
                </textarea>
                </div>

            </div>
            <div class="mt-2">
                <div>
                    <label for="status"
                        class="w-full block mb-2 text-sm font-medium text-gray-900 dark:text-white">Post
                        Status</label>
                    <select wire:model='status' id="status"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        required>
                        <option value="publish">Publish</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

            </div>
            {{-- Add 3 following elempents in 1 line. 2 input box for wordpress username and password and 1 button for post creation --}}
            <div class="mt-4 flex flex-row space-x-4">
                <div class="mt-2 w-full">
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Wordpress
                        Username</label>
                    <input type="text" id="username" wire:model='username'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Enter your WordPress username..." required>
                </div>
                <div class="mt-2 w-full">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Wordpress
                        Password</label>
                    <input type="password" id="password" wire:model='password'
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Enter your WordPress password..." required>
                </div>
            </div>
            <div class="flex justify-end">
                <div class="mt-4">
                    <button wire:click='createPost' type="button"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Create
                        Post</button>
                </div>
            </div>
        @endif
    </div>

</div>
