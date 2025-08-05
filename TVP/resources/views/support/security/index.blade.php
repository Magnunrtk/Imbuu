@extends('template.layout')
@section('title', 'Security Hints')
@section('submenuItem', 'security')
@section('content')
    <div class="TableContainer">
        <div class="CaptionContainer">
            <div class="CaptionInnerContainer">
                <span class="CaptionEdgeLeftTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionBorderTop" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionVerticalLeft" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <div class="Text">Security Hints</div>
                <span class="CaptionVerticalRight" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-vertical.gif') }});"></span>
                <span class="CaptionBorderBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/table-headline-border.gif') }});"></span>
                <span class="CaptionEdgeLeftBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
                <span class="CaptionEdgeRightBottom" style="background-image:url({{ asset('/assets/tibiarl/images/content/box-frame-edge.gif') }});"></span>
            </div>
        </div>
        <table class="Table1" cellpadding="0" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <div class="InnerTableContainer" style="max-width: unset;">
                        <table style="width:100%;">
                            <tbody>
                            <tr>
                                <td>
                                    <p>
                                        Please follow the security hints carefully to avoid losing access to your {{ config('server.serverName') }} account and to protect it from hacking attempts.
                                        This page also offers help if you have already lost your account to a hacker.
                                    </p>
                                    <h2>Security Hints</h2>
                                    <ul>
                                        <li>
                                            <b>Do not give your password or account number to anybody!</b><br>
                                            People pretending to be gamemasters or members of the {{ config('server.serverName') }} Team might contact you and ask
                                            for your password. They might tell you that they have to fix an error, or that they want to
                                            give you free items or a Golden Account. This is nonsense. Please always keep in mind that
                                            neither gamemasters nor members of the {{ config('server.serverName') }} Team will ever ask you for your account number
                                            or your password. Never give away your account number or your password to other people, not
                                            even to the {{ config('server.serverName') }} Team. Be also very careful about what you are saying in chats, emails or
                                            messaging services such as Facebook Messanger!
                                        </li>
                                        <li>
                                            <b>Enter your password or account number at no website except for {{ config('server.serverDomain') }}!</b><br>
                                            There are websites which claim to do surveys, promise you free items or offer cheat tools etc.
                                            You are usually asked to enter your password there, but the only goal of the website is to
                                            steal your account. Also, watch out for websites that fake the official {{ config('server.serverName') }} website. Only
                                            the address www.{{ config('server.serverDomain') }} will bring you to the official website of {{ config('server.serverName') }}!
                                        </li>
                                        <li>
                                            <b>Memorise your password and account number well!</b><br>
                                            Never store your account data on your computer. Also, delete any emails containing account data.
                                            If somebody gets access to your computer or email account, he must not find your password, account
                                            number or recovery key there. If you have problems to memorise your account data, note them on a
                                            piece of paper and keep it at a safe place. Make sure that nobody can find it, not even your friends!
                                        </li>
                                        <li>
                                            <b>Use secure passwords!</b><br>
                                            Your password should contain a mix of upper and lower case letters, numbers and special characters.
                                            Never choose your account number as your password and do not use common words because hackers can
                                            guess them easily. The same is true for passwords that refer to your person, e.g. the name of your
                                            pet, or your date of birth. A good strategy to find a secure password for example is to think of
                                            a sentence and pick the first letters of every word. The sentence will help you to remember your
                                            password at all times, and nobody will be able to guess it. Finally, make sure that you do not use
                                            the same password for different services. It is important that you use different passwords for
                                            your {{ config('server.serverName') }} account and your email service!
                                        </li>
                                        <li>
                                            <b>Watch out for suspicious files that can be used to hack your computer!</b><br>
                                            Some people are distributing files that contain spy software such as trojan horses or key loggers.
                                            Dangerous software like that is frequently spread through websites, emails or messaging services
                                            such as Facebook Messanger. Carefully examine any link before clicking on it. Any email attachments and
                                            downloads should be handled with caution. Most of all, cheat tools and clients that have not been
                                            released by {{ config('server.serverName') }} are often designed to hack your {{ config('server.serverName') }} account!
                                        </li>
                                        <li>
                                            <b>Update the software of your computer regularly!</b><br>
                                            Old versions of your operating system or other software frequently contains security holes that
                                            have been removed in newer versions. For example, a hacker can already spy out data from your
                                            computer if you visit a website with an old browser. Ideally, all programs on your computer
                                            should be updated to the latest available version. Most importantly, update your browser and
                                            your operating system regularly to ensure the best possible protection of your computer. Remember
                                            many programs will automatically notify you if there are available updates.
                                        </li>
                                        <li>
                                            <b>Protect your computer using up-to-date security programs!</b><br>
                                            We recommend you use anti-virus programs as well as a firewall to prevent unwanted intrusions
                                            into your computer system. Make sure that you update your firewall regularly and your anti-virus
                                            program at least once a week.
                                        </li>
                                        <li>
                                            <b>Do not play {{ config('server.serverName') }} in public networks!</b><br>
                                            If you play {{ config('server.serverName') }} on a computer to which many people have access, you can never be sure if this
                                            computer or the network it is connected to are safe. There may already be trojan horses or key
                                            loggers installed on the computer by other people. Also, the data you send through public networks
                                            such as those found in schools, libraries or internet cafes can easily be recorded by hackers.
                                            Keep in mind to close your character list after you have logged out of the game and want to leave
                                            the computer. Otherwise, it is possible that another user logs in. Therefore avoid playing in public
                                            networks!
                                        </li>
                                        <li>
                                            <b>Register your {{ config('server.serverName') }} account to your own correct email address!</b><br>
                                            The registered email address is the key to your {{ config('server.serverName') }} account. Make sure you always have access to
                                            this email account. Use your email account regularly because many email providers delete inactive
                                            email accounts. Do not create an extra email account for your {{ config('server.serverName') }} account. You might forget to
                                            use it regularly after some time. Adjust the registered email address in time if your current email
                                            account is about to change. Also, handle your email account with the same caution as your {{ config('server.serverName') }} account.
                                            A person with access to your email account might be able to hack your {{ config('server.serverName') }} account!
                                        </li>
                                        <li>
                                            <b>Do not share or trade accounts!</b><br>
                                            There is a reason why account sharing and trading is forbidden under the {{ config('server.serverName') }} Rules. Remember you
                                            are running a great risk if you give your account data to any other person. We know from experience
                                            that even close friends have stolen or ruined each other's accounts. Also, people who trade their
                                            accounts are tricked frequently by the original owner and lose their accounts. Please note that {{ config('server.serverName') }}
                                            will not provide support in case an account is lost due to account trading or sharing!
                                        </li>
                                        <li>
                                            <b>Personalise your account!</b><br>
                                            Once you create new account, you should personalise it immediately. Provided that you have
                                            entered your personal data correctly you will always be able to get your account back in case you should
                                            ever lose access. You should really take the opportunity of this additional security feature offered to
                                            premium players!
                                        </li>
                                    </ul>
                                    <h2>What to do if your account has been hacked?</h2>
                                    <p>
                                        <b>Step 1: Remove the Security Problem!</b><br>
                                        The very first thing that you have to do is to find out how somebody got your account data.
                                        Remember that if you have not removed the security problem, the hacker can again get access
                                        to your account. Below you will find a list of questions that might help you to find the
                                        security problem and to remove it.
                                    </p>
                                    <ul>
                                        <li>
                                            Did you download or open any files that possibly contained spy software such as trojan
                                            horses or key loggers? Remember there is a risk that your computer gets infected by spy
                                            software whenever you get emails containing attachments, visit websites or receive any
                                            kind of files, even if they have been sent by close friends. Therefore you should run
                                            one or two up-to-date anti-virus programs on your computer and remove any infected files.
                                            From our experience the majority of hacking cases are caused by spy software. For this
                                            reason you should be extremely careful whenever you receive any files no matter how
                                            trustworthy the source may be.
                                        </li>
                                        <li>
                                            Did you play {{ config('server.serverName') }} on a computer other than your own? Always remember that you can never
                                            be sure that computers owned by other persons are not infected by viruses or key loggers.
                                            Inform the owner of the other computer that there might be a security problem that should
                                            be removed. Avoid playing on other computers otherwise you risk losing your account again.
                                        </li>
                                        <li>
                                            Did you give your account data to somebody else or did you share your account with a friend?
                                            Is it possible that somebody found a piece of paper with your account data on it? Always
                                            remember not to give your account data to anybody, not even to people who claim to be
                                            gamemasters or members of the {{ config('server.serverName') }} Team. Often friends trick each other if the characters
                                            are quite valuable or they ruin characters carelessly. For this reason do not entrust your
                                            hard-earned characters to your friends. Make sure to store your account data in a safe place.
                                        </li>
                                        <li>
                                            Is it possible that your email account has been hacked and that somebody found an email
                                            containing your account number, password or recovery key? In this case secure your email
                                            account immediately with a new password or contact your email provider for assistance.
                                            You might also consider changing the email address your {{ config('server.serverName') }} account is registered to.
                                            Also, make yourself familiar with the security guidelines of your email provider to avoid
                                            further problems.
                                        </li>
                                        <li>
                                            Did you buy the account from somebody or did you trade it? Often the original holder of
                                            a {{ config('server.serverName') }} account has personalised it to himself and received the recovery key. By using
                                            this recovery key the holder can get his account back anytime because {{ config('server.serverName') }} considers
                                            the person to whom an account is personalised to be the rightful holder of that account.
                                            For this reason account trading is forbidden under the {{ config('server.serverName') }} Rules, and {{ config('server.serverName') }} will not
                                            provide support to players who cannot prove they are the rightful holders of an account.
                                            Also, note that {{ config('server.serverName') }} cannot help you if you are tricked at a trade or if you lose items
                                            that you have bought from players.
                                        </li>
                                        <li>
                                            Did you enter your account number or password at any other website than www.{{ config('server.serverDomain') }}?
                                            Perhaps you have entered your account data on a website which you thought was www.{{ config('server.serverDomain') }},
                                            but you did not get the expected result? Always remember to check the address carefully
                                            before you enter your account data on a website. Only if you see www.{{ config('server.serverDomain') }} in it,
                                            it is safe to enter your account data.
                                        </li>
                                        <li>
                                            Are you sure your password was secure, and that it was not possible to guess? Always make
                                            sure to use a secure password for your {{ config('server.serverName') }} account. Your password should contain a mix
                                            of upper and lower case letters, numbers and special characters.
                                        </li>
                                    </ul>
                                    <p>
                                        If none of these questions helps you to find the security problem, do not simply forget about it.
                                        There must be a security problem, otherwise you would not have been hacked. Remember you must
                                        remove the security problem before trying to get your account back. If you can exclude all
                                        other possible explanations, it is still possible that there is a key logger on your computer
                                        that cannot be found by your anti-virus program. To be absolutely sure to get rid of all viruses
                                        and key loggers, you need to format all hard disks and to re-install your computer system.
                                        Remember that not only your {{ config('server.serverName') }} account is at stake if your computer is infected by spy
                                        software, but possibly also other confidential data such as bank account information.
                                    </p>
                                    <p>
                                        <b>Step 2: Get Your Account Back!</b><br>
                                        Once you have removed the security problem you can get back access to your account by using
                                        the <a href="{{ route('account.lost.index') }}">Lost Account Interface</a>. Of course,
                                        you need to prove that your claim to the account is justified. Enter the requested data and
                                        follow the instructions carefully. Please understand there is no way to get access to your
                                        lost account if the interface cannot help you.
                                    </p>
                                    <p>
                                        <b>Step 3: Follow the Security Hints!</b><br>
                                        Losing your account is the hard way to learn that you should be careful with your account data.
                                        Please make sure to follow the security hints that are stated above from now on. Otherwise you
                                        might make another mistake that a hacker could take advantage of.
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection