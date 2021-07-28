<!-- <h3>Hi, {{ $user->username }}</h3>
<p>{{$error}}</p>
<p>
    <a href="url(/teams)"> 
        <b> Request a review</b>
    </a>
</p> -->

// Mail::send('emails.ban-mail', ['user' => $user, 'error'=>$error], function ($m) use ($user, $admin) {
            //     $m->from($admin->email, 'TVZ Sports');
    
            //     $m->to($user->email, $user->username)->subject('Account Suspension');
            // });

            // $data = array('name'=>"Virat Gandhi");
   
            // Mail::send(['text'=>'mail/mail'], $user, function($message) {
            //     $message->to('abc@gmail.com', 'Tutorials Point')->subject
            //         ('Laravel Basic Testing Mail');
            //     $message->from('xyz@gmail.com','Virat Gandhi');
            // });
            // echo "Basic Email Sent. Check your inbox.";




























            // if ($request->status === 'banned') {
        //     $ban = $user->update([
        //         'status'=> $request->status,
        //         'policy_id'=> $request->policy_id,
        //         'ban_date'=> $request->ban_date,
        //         'ban_till'=> $request->ban_till,
        //     ]);
        //     if ($ban) {
        //         $message = 'User Banned Successfully!';
        //     }


        // } elseif ($request->status === 'active') {
        //     $unban = $user->update([
        //         'status'=> $request->status,
        //         'policy_id'=> null,
        //         'ban_date'=> null,
        //         'ban_till'=> null,
        //     ]);
        //     if ($unban) {
        //         $message = 'User Activated Successfully!';
        //     }
        // }
