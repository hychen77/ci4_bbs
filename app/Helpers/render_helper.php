<?php
 
if ( ! function_exists('render'))
{
    function render(string $name, array $data = [], array $options = [])
    {
        if(!isset($_SESSION['userid'])){
            echo "<script>alert('로그인하십시오.');location.href='/login'</script>";
            exit;
        }

        return view(
            'layout',
            [
                'content' => view($name, $data, $options),
            ],
            $options
        );
    }
}