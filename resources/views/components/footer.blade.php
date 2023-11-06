<?php
 $fecha = date('Y'); 

 $verEs = App\Models\Version::where('flag_trash', 0)->where('status', 'Minimo')->orWhere('status', 'Actual')->first();
       
 ?>
<footer class="sticky bottom-0 bg-gray-100 text-center lg:text-left hidden md:block">
    <div class="text-gray-700 text-center p-2 bg-white dark:bg-dark-eval-1">
       <span class="dark:text-white"> © <?php echo $fecha; ?> Derechos Reservados -</span> 
        <a class="text-red-600 font-extrabold" href="https://www.fullgas.com.mx">FULLGAS</a>
        <span class="float-right dark:text-white"> Versión: <span class="text-gray-400">{{ $verEs->version }}</span></span> 
    </div>
</footer>