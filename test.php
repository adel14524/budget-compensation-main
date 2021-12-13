<canvas id='expchart' width='50' height='16'>
                                <script type='text/javascript'>
                                    var cntxt = document.getElementById('expchart').getContext('2d');
                                    var exp = new Chart(cntxt, {
                                        type: 'bar',
                                        data: {
                                            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                            datasets: [{
                                                label: 'Category1',
                                                data: [2000,4000,7000,5000,7000,1000,800,500,1000,2000,4000,1020],
                                                backgroundColor: 'rgba(8,10,51,1)',
                                                },
                                                {
                                                label: 'Category2',
                                                data: [100,50,400,200,300,500,1000,800,100,500,600,300],
                                                backgroundColor: 'rgba(224,228,232,1)',
                                                },
                                                {
                                                label: 'Category3',
                                                data: [100,50,400,200,300,500,1000,800,100,500,600,300],
                                                backgroundColor: 'rgba(5,183,138,1)',
                                                },
                                                {
                                                label: 'Category4',
                                                data: [100,50,400,200,300,500,1000,800,100,500,600,300],
                                                backgroundColor: 'rgba(5,42,229,1)',
                                            }],
                                        },
                                        options: {
                                            responsive: true,
                                            scales: {
                                              x: {
                                                stacked: true,
                                              },
                                              y: {
                                                stacked: true,
                                              }
                                            }
                                        } 
                                    });
                                </script>
                            </canvas>