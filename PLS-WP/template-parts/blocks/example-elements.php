<?php 
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<div id="exampleelements" class="w-screen h-full p-2 bg-[#EFEFF1]">
    <h1 class="font-bold text-2xl">Example Header</h1>
        <hr class="py-2 border-borderGray" />
    <div id="exampleHeader-container" class="w-full bg-white inline-flex p-4 pb-0">
        <div id="exampleHeader-content" class="w-full space-y-4">
            <div id="headerNavButtonGroup" class="w-full flex justify-between items-center">
                <button class="bg-white inline-flex items-center justify-start text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                    <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p>All Agencies</p>                
                </button>  
                <button class="bg-white inline-flex float-right items-center text-black py-1 px-2 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                        <p>Action</p>                
                </button>            
            </div>

            <div id="headerTitle" class="w-full inline-flex items-center space-x-4">
                <div id="headerTitle-icon" class="w-auto">
                    <span class="material-symbols-outlined md-18 text-white bg-badgeDarkBlue rounded-xl p-2" style="font-size: 48px">
                        local_police
                    </span>
                </div>
                <div id="headerTitle-TextGroup">
                    <p class="text-3xl font-bold">Springfield Police Dept</p>
                    <h1 class="text-base font-thin">Some Subheadline</h1>
                </div>
                <div class="rounded-xl px-4 items-center flex h-7 bg-badgeLightBlue text-sm">
                    <p class=" text-badgeDarkBlue">
                        Badge
                    </p>
                </div>
            </div>

            <div id="headerTabGroup" class="w-full bg-white inline-flex ">
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Lessons</p>    
                </button>
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-badgeDarkBlue hover:border-badgeDarkBlue text-badgeDarkBlue">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Lessons</p>    
                </button>    
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 border-b-4 border-white hover:border-badgeLightBlue">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Lessons</p>    
                </button>            
            </div>
        </div>

    </div>

    

    <h1 class="font-bold text-2xl">Example Elements</h1>
    <hr class="py-2 border-borderGray" />
    <div class="flex flex-wrap w-full space-y-5">
        <div class="w-full h-1/4 bg-white border-borderGray border-2 rounded-xl py-3 px-4">
            <div class="w-full grid grid-cols-2 space-y-2">
                <div id="gridbox-element" class="w-1/2">
                    <h2 class="text-base" >Label Text</h2>
                    <p class="text-xl">Item Text</p>
                </div>
                <div id="gridbox-element" class="w-1/2">
                    <h2 class="text-base" >Label Text</h2>
                    <p class="text-xl">Item Text</p>
                </div>
                <div id="gridbox-element" class="w-1/2">
                    <h2 class="text-base" >Label Text</h2>
                    <p class="text-xl">Item Text</p>
                </div>
                <div id="gridbox-element" class="w-1/2">
                    <h2 class="text-base" >Label Text</h2>
                    <p class="text-xl">Item Text</p>
                </div>
            </div>
        </div>


        <div id="example-buttons" class="w-full">
            <h2>Buttons</h2>
            <div class="inline-flex space-x-2">
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-6 border-2 border-[#EFEFF1] rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150">
                    <span class="material-symbols-outlined">
                        arrow_back
                    </span>
                    <p>All People</p>
                </button>
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-6 border-2 border-[#EFEFF1] rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150">
                    <span class="material-symbols-outlined">
                        info
                    </span>
                    <p>Details</p>    
                </button>
            </div>
        </div>


        <div id="toggleGroupExample-container" class="w-auto p-1 space-x-1 inline-flex rounded-xl border-[1px] border-borderGray">
            <button class="inline-flex space-x-1 w-auto p-2 bg-white rounded-lg">
                <span class="material-symbols-outlined">
                    info
                </span>
                <p>All Users</p> 
            </button>
            <button class="inline-flex space-x-1 w-auto p-2 rounded-lg hover:bg-borderGray hover:bg-opacity-25 transition-all duration-200">
                <span class="material-symbols-outlined">
                    info
                </span>
                <p>User Groups</p> 
            </button>
        </div>

        <div id="inputExample" class="w-full">
            <h2>Input</h2>
            <hr class="py-2 border-borderGray" />
            <div class="inline-flex w-full items-center space-x-2">
                <div class="w-1/3 relative">
                    <!-- Material-UI Icon -->
                    <span class="material-symbols-outlined absolute left-3 top-3 text-gray-500">search</span>

                    <!-- Input Field with Padding to accommodate the icon and placeholder text -->
                    <input type="text" name="inputExample" id="inputExample" class="w-full border-2 border-borderGray rounded-lg pl-12 pr-4 py-2" placeholder="Input Placeholder" />
                </div>

                <div class="w-1/3 relative">
                    <!-- Material-UI Icon -->
                    <button class="w-full bg-white border-2 border-borderGray rounded-lg text-left p-2">
                        Multi-Select
                    </button>
                    <!-- Input Field with Padding to accommodate the icon and placeholder text -->
                    <span class="material-symbols-outlined absolute right-3 top-3 text-gray-500">expand_more</span>

                </div>
            </div>



        </div>        
        <div id="listExamples" class="w-full space-y-4">
            <div id="list-item-closed" class="w-full align-middle rounded-xl bg-white inline-flex p-4 space-x-5 px-4 border-[#B9BBC0] border-2">
                
                <div id="list-item-icon" class="flex justify-center items-center w-1/12 aspect-square rounded-xl border-2 border-borderPurple">
                    <span class="material-symbols-outlined md-18 text-iconPurple" style="font-size: 48px">
                        school
                    </span>
                </div>
                <div id="list-item-text" class="w-4/6 flex justify-start items-center">
                    <div class="w-full">
                        <h2 class="text-xl font-bold text-textNeutral" >Dispatch Pro - 16</h2>
                        <p class="text-base text-textNeutral">16 Lessons</p>
                    </div>
                </div>
                <div id="list-item-button-group" class="w-full flex justify-end items-center space-x-3">
                    <!-- Text Button -->
                    <button class="bg-white text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                        <p class="inline-block whitespace-nowrap">View Course</p>
                    </button>

                    <!-- Icon Buttons -->
                    <button class="bg-buttonBackgroundGray text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 flex justify-center items-center">
                        <span class="material-symbols-outlined">more_horiz</span>
                    </button>
                    <button class="bg-buttonBackgroundGray text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 flex justify-center items-center">
                        <span class="material-symbols-outlined">expand_more</span>
                    </button>
                </div>
            </div>

        </div>

        <div id="expande" class="w-full border-2 border-borderGray rounded-md bg-white p-4 space-y-4">
            <div id="header" class="w-full">
                <div id="list-item-open" class="w-full align-middle rounded-xl bg-white inline-flex space-x-5">
                    
                    <div id="list-item-icon" class="flex justify-center items-center w-1/12 aspect-square rounded-xl border-2 border-blueAgencyBorder">
                        <span class="material-symbols-outlined md-18 text-blueAgencyForeground" style="font-size: 48px">
                            local_police
                        </span>
                    </div>
                    <div id="list-item-text" class="w-4/6 flex justify-start items-center">
                        <div class="w-full">
                            <h2 class="text-xl font-bold text-textNeutral" >Buffalo Police Dept</h2>
                            <p class="text-base text-textNeutral">2 user groups</p>
                        </div>
                    </div>
                    <div id="list-item-button-group" class="w-full flex justify-end items-center space-x-3">
                        <!-- Text Button -->
                        <button class="bg-white text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 text-sm">
                            <p class="inline-block whitespace-nowrap">View Course</p>
                        </button>

                        <!-- Icon Buttons -->
                        <button class="bg-buttonBackgroundGray text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 flex justify-center items-center">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </button>
                        <button class="bg-buttonBackgroundGray text-black py-2 px-4 border-2 border-buttonBorderGray rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150 flex justify-center items-center">
                            <span class="material-symbols-outlined">expand_more</span>
                        </button>
                    </div>
                </div>
            </div>
            <div id="header" class="w-full rounded-xl border-2 border-borderGray">
                <table class="min-w-full rounded-xl divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800 rounded-md">
                            <tr>
                                <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <button class="flex items-center gap-x-3 focus:outline-none">
                                        <span>USER GROUP</span>

                                        <svg class="h-3" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                            <path d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                            <path d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z" fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                        </svg>
                                    </button>
                                </th>

                                <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    MEMBER SINCE
                                </th>

                                <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left text-gray-500 dark:text-gray-400">
                                    ...
                                </th>

                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                <tr>
                                <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                    <div>
                                        <h2 class="font-medium text-gray-800 dark:text-white ">Catalog</h2>
                                        <p class="text-sm font-normal text-gray-600 dark:text-gray-400">hi</p>
                                    </div>
                                </td>
                                <td class="px-12 py-4 text-sm font-medium whitespace-nowrap">
                                    <div class="inline px-3 py-1 text-sm font-normal rounded-full text-emerald-500 gap-x-2 bg-emerald-100/60 dark:bg-gray-800">
                                        Member Since
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                    <div>
                                        <p class="text-gray-500 dark:text-gray-400">
                                            hi
                                        </p>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
            </div>
        </div>

        <div id="example-buttons" class="w-full">
            <h2 class=" w-full border-t-1 border-b-1 border-black">Tab Group</h2>
            <div class="inline-flex space-x-2 ">
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150">
                    <span class="material-symbols-outlined">
                        arrow_back
                    </span>
                    <p>All People</p>
                </button>
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150">
                    <span class="material-symbols-outlined">
                        group
                    </span>
                    <p>Lessons</p>    
                </button>
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150">
                    <span class="material-symbols-outlined">
                        local_police
                    </span>
                    <p>Agencies</p>    
                </button>
                <button class="inline-flex bg-white text-black font-bold space-x-1 py-2 px-4 rounded-lg hover:bg-[#EFEFF1] hover:bg-opacity-25 transition-colors duration-150">
                    <span class="material-symbols-outlined">
                        kid_star
                    </span>
                    <p>Certificates</p>    
                </button>
            </div>
        </div>
    </div>
</div>
