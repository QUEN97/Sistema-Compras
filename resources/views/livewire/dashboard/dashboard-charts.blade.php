<div class="w-full h-full text-center flex flex-wrap justify-center items-center gap-6">

    <div class="p-6 bg-white dark:bg-dark-eval-0 rounded shadow w-[90%]">
        {!! $chartSol->container() !!}
    </div>
    
    <div class="p-6 bg-white dark:bg-dark-eval-0 dark:text-white w-1/2 rounded shadow min-w-[300px] flex items-center justify-center ">
        {!! $chartRepuestos->container() !!}
    </div>
    <div class="p-6 bg-white dark:bg-dark-eval-0  rounded shadow w-[300px] md:w-[60%] ">
        {!! $chartPR->container() !!}
    </div>
    
    <script src="{{ $chartRepuestos->cdn() }}"></script>
    
    {{ $chartRepuestos->script() }}
    {{ $chartPR->script() }}
    {{ $chartSol->script() }}
</div>