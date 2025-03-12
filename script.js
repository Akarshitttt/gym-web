$(document).ready(function(){

    $('#menu').click(function(){
        $(this).toggleClass('fa-times');
        $('.navbar').toggleClass('active');
    });

    $(window).on('scroll load', function(){

        $('#menu').removeClass('fa-times');
        $('.navbar').removeClass('active');

        if($(window).scrollTop() > 60){
            $('.header').addClass('active');
        }
        else{
            $('.header').removeClass('active');
        }

        $('section').each(function(){

            let top = $(window).scrollTop();
            let height = $(this).height();
            let offset = $(this).offset().top - 200;
            let id = $(this).attr('id');

            if(top >= offset && top < offset + height){
                $('.navbar a').removeClass('active');
                $('.navbar').find(`[href="#${id}"]`).addClass('active');
            }

        });

    });

    // Load members from localStorage
    const storedMembers = JSON.parse(localStorage.getItem('members')) || [];
    const memberList = $("#member-list");

    storedMembers.forEach(member => {
        const memberBox = `
            <div class="box">
                <h3>Member Name: ${member.name}</h3>
                <p>Membership Plan: ${member.plan}</p>
                <p>Join Date: ${member.joinDate}</p>
                <p>Contact: ${member.contact}</p>
            </div>
        `;
        memberList.append(memberBox);
    });

    // Handle registration form submission
    $("#registration-form").submit(function(event) {
        event.preventDefault();

        const name = $("#name").val();
        const email = $("#email").val();
        const plan = $("#plan").val();
        const joinDate = new Date().toLocaleDateString();

        const newMember = { name, plan, joinDate, contact: email };
        storedMembers.push(newMember);
        localStorage.setItem('members', JSON.stringify(storedMembers));

        alert("Member registered successfully!");
        window.location.href = "dashboard.html";
    });

    // Handle click event for floating effect
    $(document).on('click', '.dashboard .box', function() {
        $(this).toggleClass('active');
        setTimeout(() => {
            $(this).removeClass('active');
        }, 1000);
    });

});
