@extends('templates.header.owner')

@section('content')
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg border border-green-600 bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      {{ session('success') }}
    </div>
  @endif

    <div class="grid gap-4 mb-4 xl:grid-cols-3">
    <a href="#"
      class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Menu</h5>
      <p class="font-normal text-gray-700 dark:text-gray-400"></p>
    </a>
    <a href="#"
      class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Penjualan</h5>
      <p class="font-normal text-gray-700 dark:text-gray-400"></p>
    </a>
    <a href="#"
      class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">

      <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pendapatan</h5>
      <p class="font-normal text-gray-700 dark:text-gray-400"></p>
    </a>
    </div>
    <div
    class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
    <div class="flex items-center justify-between mb-4">
      <div class="flex-shrink-0">
      <span class="text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">$45,385</span>
      <h3 class="text-base font-light text-gray-500 dark:text-gray-400">Sales this week</h3>
      </div>
      <div class="flex items-center justify-end flex-1 text-base font-medium text-green-500 dark:text-green-400">
      12.5%
      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd"
        d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
        clip-rule="evenodd"></path>
      </svg>
      </div>
    </div>
    <div id="main-chart"></div>
    <!-- Card Footer -->
    <div class="flex items-center justify-between pt-3 mt-4 border-t border-gray-200 sm:pt-6 dark:border-gray-700">
      <div>
      <button
        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 rounded-lg hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
        type="button" data-dropdown-toggle="weekly-sales-dropdown">Last 7 days <svg class="w-4 h-4 ml-2" fill="none"
        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg></button>
      <!-- Dropdown menu -->
      <div
        class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
        id="weekly-sales-dropdown">
        <div class="px-4 py-3" role="none">
        <p class="text-sm font-medium text-gray-900 truncate dark:text-white" role="none">
          Sep 16, 2021 - Sep 22, 2021
        </p>
        </div>
        <ul class="py-1" role="none">
        <li>
          <a href="#"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
          role="menuitem">Yesterday</a>
        </li>
        <li>
          <a href="#"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
          role="menuitem">Today</a>
        </li>
        <li>
          <a href="#"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
          role="menuitem">Last 7 days</a>
        </li>
        <li>
          <a href="#"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
          role="menuitem">Last 30 days</a>
        </li>
        <li>
          <a href="#"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
          role="menuitem">Last 90 days</a>
        </li>
        </ul>
        <div class="py-1" role="none">
        <a href="#"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
          role="menuitem">Custom...</a>
        </div>
      </div>
      </div>
      <div class="flex-shrink-0">
      <a href="#"
        class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-primary-700 sm:text-sm hover:bg-gray-100 dark:text-primary-500 dark:hover:bg-gray-700">
        Sales Report
        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
      </a>
      </div>
    </div>
    </div>
  </div>
@endsection