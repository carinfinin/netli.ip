function getInfoIp (form) {

    BX.ajax.runAction('netli:ip.api.GeoIpDataController.getGeoIp', {
        data: {
            ip: form.elements['ip'].value
        }
    })
        .then(function(response){
            if(response.status === "success" && response.data.success) {

                const result = document.querySelector('.geoip-form__result ')
                const ip = document.querySelector('#ip')
                const country = document.querySelector('#country')
                const city = document.querySelector('#city')
                const region = document.querySelector('#region')
                const latitude = document.querySelector('#latitude')
                const longitude = document.querySelector('#longitude')
                const provider = document.querySelector('#provider')


                console.log(response.data.data.region)
                console.log(response.data.data.latitude)
                console.log(response.data.data.longitude)
                console.log(response.data.data.city)

                ip.innerHTML = response.data.data.ip
                country.innerHTML = response.data.data.country
                city.innerHTML = response.data.data.city
                region.innerHTML = response.data.data.region
                latitude.innerHTML = response.data.data.latitude
                longitude.innerHTML = response.data.data.longitude
                provider.innerHTML = response.data.data.provider

                result.classList.remove('hidden')
            }
        }).catch((err) => {
        console.error(err)
    })

}