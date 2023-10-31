<html>

<head>
    <meta charset="UTF-8">
    <title>Zego Express Video Call</title>
    <style type="text/css">
        * {
            font-family: sans-serif;
        }

        h1,
        h4 {
            text-align: center;
        }

        #local-video, #remote-video {
            width: 400px;
            height: 300px;
            border: 1px solid #dfdfdf;
        }

        #local-video {
            position: relative;
            margin: 0 auto;
            display: block;
        }

        #remote-video {
            display: flex;
            margin: auto;
            position: relative !important;
        }
    </style>
    <script src="{{asset('/js/ZegoExpressWebRTC-3.0.0.js')}}"></script>
</head>

<body>
<h1>
    Zego RTC Video Call
</h1>
<h4>Local video</h4>
<div id="local-video"></div>
<h4>Remote video</h4>
<div>

    <video id="remote-video" autoplay playsinline controls></video>

</div>
{{--<script src="{{asset('/js/index.js')}}"></script>--}}

{{--<script>--}}
{{--    var appID = 1553886775;--}}
{{--    var server = "wss://webliveroom1553886775-api.coolzcloud.com/ws";--}}
{{--    const zg = new ZegoExpressEngine(appID, server);--}}

{{--    async function checkRequirements() {--}}
{{--        // const result = await zg.checkSystemRequirements();--}}
{{--        // console.log('checkSystemRequirements ', result);--}}
{{--    }--}}

{{--    async function loginRoom() {--}}
{{--        const roomID = '1357';--}}
{{--        const token = '04AAAAAGU8tW0AEDl3bXN4OG1hdTExM3Rmc3QAoO66rrBDq3s6SL/cPlMNRYRNzhp7k3f42vagRkjJ3kxv0H3cJyZkg4fc6NalwLFZQaeyOWfurVHorNX/1z3gX4sFD4D8mN/VQwdBUIVmEjra0OlGKmqlWHYgHR0XohywsoBtzAVTt8NaPImqEe2S1Y6U26eBx5mLvccj016RkXdKNKwUgQ0z/zPvxgLD8tE0X55Ng/OLoGfF/5DYwceuiEA=';--}}
{{--        const userID = '199';--}}
{{--        const userName = 'saad';--}}
{{--        const result = await zg.loginRoom(roomID, token, {userID, userName}, {userUpdate: true});--}}
{{--        console.log('login room success', result);--}}

{{--        const streamID = '1357_200_main';--}}

{{--        const remoteVideo = document.getElementById('remote-video');--}}
{{--        remoteVideo.srcObject = await zg.startPlayingStream(streamID);--}}

{{--        zg.on('roomStreamUpdate', (roomID, updateType, streamList, extendedData) => {--}}
{{--            if (updateType === 'ADD' && streamList.length > 0) {--}}
{{--                const newHostUserID = streamList[0].user.userID;--}}

{{--                if (newHostUserID === userID) {--}}
{{--                    console.log('New user is now the co-host');--}}
{{--                }--}}
{{--            }--}}
{{--        });--}}
{{--    }--}}


{{--    loginRoom();--}}
{{--    checkRequirements();--}}
{{--</script>--}}

</body>

</html>
