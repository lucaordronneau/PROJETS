document.addEventListener("DOMContentLoaded", () => {
    const grid = document.querySelector('.grid')
    const scoreDisplay = document.getElementById('score')
    const scoreInput = document.getElementById('score_input')
    const jouerInput = document.getElementById('jouer_input')

    let mv_fantomes = 0
    const width = 28
    let score = 0
    const layout = [
        1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
        1,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,1,
        1,0,1,1,1,1,0,1,1,1,1,1,0,1,1,0,1,1,1,1,1,0,1,1,1,1,0,1,
        1,3,1,1,1,1,0,1,1,1,1,1,0,1,1,0,1,1,1,1,1,0,1,1,1,1,3,1,
        1,0,1,1,1,1,0,1,1,1,1,1,0,1,1,0,1,1,1,1,1,0,1,1,1,1,0,1,
        1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,
        1,0,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,0,1,
        1,0,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,0,1,
        1,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0,0,0,0,1,
        1,1,1,1,1,1,0,1,1,1,1,1,0,1,1,0,1,1,1,1,1,0,1,1,1,1,1,1,
        1,1,1,1,1,1,0,1,1,4,4,4,4,4,4,4,4,4,4,1,1,0,1,1,1,1,1,1,
        1,1,1,1,1,1,0,1,1,4,1,1,1,2,2,1,1,1,4,1,1,0,1,1,1,1,1,1,
        1,1,1,1,1,1,0,1,1,4,1,2,2,2,2,2,2,1,4,1,1,0,1,1,1,1,1,1,
        4,4,4,4,4,4,0,0,0,4,1,2,2,2,2,2,2,1,4,0,0,0,4,4,4,4,4,4,
        1,1,1,1,1,1,0,1,1,4,1,2,2,2,2,2,2,1,4,1,1,0,1,1,1,1,1,1,
        1,1,1,1,1,1,0,1,1,4,1,1,1,1,1,1,1,1,4,1,1,0,1,1,1,1,1,1,
        1,1,1,1,1,1,0,1,1,4,1,1,1,1,1,1,1,1,4,1,1,0,1,1,1,1,1,1,
        1,0,0,0,0,0,0,0,0,4,4,4,4,4,4,4,4,4,4,0,0,0,0,0,0,0,0,1,
        1,0,1,1,1,1,0,1,1,1,1,1,0,1,1,0,1,1,1,1,1,0,1,1,1,1,0,1,
        1,0,1,1,1,1,0,1,1,1,1,1,0,1,1,0,1,1,1,1,1,0,1,1,1,1,0,1,
        1,3,0,0,1,1,0,1,1,0,0,0,0,0,0,0,0,0,0,1,1,0,1,1,0,0,3,1,
        1,1,1,0,1,1,0,1,1,0,1,1,1,1,1,1,1,1,0,1,1,0,1,1,0,1,1,1,
        1,1,1,0,1,1,0,1,1,0,1,1,1,1,1,1,1,1,0,1,1,0,1,1,0,1,1,1,
        1,0,0,0,0,0,0,1,1,0,0,0,0,1,1,0,0,0,0,1,1,0,0,0,0,0,0,1,
        1,0,1,1,1,1,1,1,1,1,1,1,0,1,1,0,1,1,1,1,1,1,1,1,1,1,0,1,
        1,0,1,1,1,1,1,1,1,1,1,1,0,1,1,0,1,1,1,1,1,1,1,1,1,1,0,1,
        1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,
        1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
    ]


    const squares = []

    function createBoard() {
        for (let i=0; i < layout.length; i++) {
            const square = document.createElement('div')
            console.log(square)
            grid.appendChild(square)
            squares.push(square)

            if (layout[i] === 0) {
                squares[i].classList.add('pac-dot')
            } else if (layout[i] === 1) {
                squares[i].classList.add('wall')
            } else if (layout[i] === 2) {
                squares[i].classList.add('ghost-lair')
            } else if (layout[i] === 3) {
                squares[i].classList.add('power-pellet')
            } else {
                squares[i].classList.add('nothing')
            }
        }
    }

    createBoard()

    let pacmanCurrentIndex = 490

    squares[pacmanCurrentIndex].classList.add('pac-man')

    function movePacman(e) {


            squares[pacmanCurrentIndex].classList.remove('pac-man')

            switch (e.keyCode) {
                case 81: //left
                    mv_fantomes +=1

                    if (pacmanCurrentIndex % width !== 0 && !squares[pacmanCurrentIndex - 1].classList.contains('wall') && !squares[pacmanCurrentIndex - 1].classList.contains('ghost-lair')) {
                        pacmanCurrentIndex -= 1
                    }

                    if ((pacmanCurrentIndex - 1) === 363) {
                        pacmanCurrentIndex = 391
                    }
                    document.getElementById("q").style.backgroundColor = "darkgrey"
                    break
                case 90: //up
                    mv_fantomes +=1

                    if (pacmanCurrentIndex - width >= 0 && !squares[pacmanCurrentIndex - width].classList.contains('wall') && !squares[pacmanCurrentIndex - width].classList.contains('ghost-lair')) {
                        pacmanCurrentIndex -= width
                    }
                    document.getElementById("z").style.backgroundColor = "darkgrey"
                    break
                case 68: //right
                    mv_fantomes +=1

                    if (pacmanCurrentIndex % width < width - 1 && !squares[pacmanCurrentIndex + 1].classList.contains('wall') && !squares[pacmanCurrentIndex + 1].classList.contains('ghost-lair')) {
                        pacmanCurrentIndex += 1
                    }

                    if ((pacmanCurrentIndex + 1) === 392) {
                        pacmanCurrentIndex = 364
                    }
                    document.getElementById("d").style.backgroundColor = "darkgrey"
                    break
                case 83: //down
                    mv_fantomes +=1
                    if (pacmanCurrentIndex + width < width * width && !squares[pacmanCurrentIndex + width].classList.contains('wall') && !squares[pacmanCurrentIndex + width].classList.contains('ghost-lair')) {
                        pacmanCurrentIndex += width
                    }
                    document.getElementById("s").style.backgroundColor = "darkgrey"
                    break
            }

            squares[pacmanCurrentIndex].classList.add('pac-man')
        console.log(mv_fantomes)


        pacmanEatDot()
        eatPowerPellet()
        checkGameOver()
    }

    function changeKeys(e) {
        switch (e.keyCode) {
            case 81: //left
                console.log("left")
                document.getElementById("q").style.backgroundColor = "blue"
                break
            case 90: //up
                console.log("up")
                document.getElementById("z").style.backgroundColor = "blue"
                break
            case 68: //right
                console.log("right")
                document.getElementById("d").style.backgroundColor = "blue"
                break
            case 83: //down
                console.log("down")
                document.getElementById("s").style.backgroundColor = "blue"
                break
        }
        console.log("Smt changed")
    }

    document.addEventListener('keyup', movePacman)
    document.addEventListener("keydown", changeKeys)


    function pacmanEatDot () {
        if (squares[pacmanCurrentIndex].classList.contains('pac-dot')) {
            score++
            squares[pacmanCurrentIndex].classList.remove('pac-dot')
            squares[pacmanCurrentIndex].classList.add('nothing')
            scoreDisplay.innerHTML = score
            scoreInput.value = score
        }
    }

    function eatPowerPellet() {
        if (squares[pacmanCurrentIndex].classList.contains('power-pellet')) {
            score += 10
            ghosts.forEach(ghost => ghost.isScared = true)
            setTimeout(unScareGhosts, 10000)
            squares[pacmanCurrentIndex].classList.remove('power-pellet')
            squares[pacmanCurrentIndex].classList.add('nothing')
        }
    }

    function unScareGhosts() {
        ghosts.forEach(ghost => ghost.isScared = false)
    }

    class Ghost {
        constructor(className, startIndex, speed) {
            this.className = className
            this.startIndex = startIndex
            this.speed = speed
            this.currentIndex = startIndex
            this.timerId = NaN
            this.isScared = false
        }
    }

    ghosts = [
        new Ghost('blinky', 348, 250),
        new Ghost('pinky', 376, 400),
        new Ghost('inky', 351, 300),
        new Ghost('clyde', 379, 500)
    ]

    ghosts.forEach(ghost => {
        squares[ghost.currentIndex].classList.add(ghost.className)
        squares[ghost.currentIndex].classList.add('ghost')
    })


        ghosts.forEach(ghost => moveGhost(ghost));


    function getOutOfGhostLair(direction, ghost) {
        let res = 0
        if (!squares[ghost.currentIndex - width].classList.contains('ghost') && !squares[ghost.currentIndex - width].classList.contains('wall')) {
            res = -width
        } else if (ghost.currentIndex < 349) {
            res = +1
        } else if (ghost.currentIndex > 350) {
            res = -1
        }
        return res
    }

    function moveGhost(ghost) {


            const directions = [-1, +1, width, -width]
            let direction = directions[Math.floor(Math.random() * directions.length)]
            ghost.timerId = setInterval(function () {
                if(mv_fantomes>0) {
                console.log(ghost.className)
                console.log(ghost.currentIndex)
                if (squares[ghost.currentIndex].classList.contains('ghost-lair')) {
                    direction = getOutOfGhostLair(direction, ghost)
                    squares[ghost.currentIndex].classList.remove(ghost.className, 'ghost', 'scared-ghost')
                    ghost.currentIndex += direction
                    console.log(ghost.className + " se déplace en " + direction)
                    squares[ghost.currentIndex].classList.add(ghost.className, 'ghost')
                } else if (!squares[ghost.currentIndex + direction].classList.contains('wall') && !squares[ghost.currentIndex + direction].classList.contains('ghost')) {
                    squares[ghost.currentIndex].classList.remove(ghost.className, 'ghost', 'scared-ghost')
                    ghost.currentIndex += direction
                    console.log(ghost.className + " se déplace en " + direction)
                    squares[ghost.currentIndex].classList.add(ghost.className, 'ghost')
                } else {
                    direction = directions [Math.floor(Math.random() * directions.length)]
                    console.log(ghost.className + " se déplace en " + direction)
                }

                if (ghost.isScared) {
                    squares[ghost.currentIndex].classList.add('scared-ghost')
                }
                checkGameOver()

                if (ghost.isScared && squares[ghost.currentIndex].classList.contains('pac-man')) {
                    squares[ghost.currentIndex].classList.remove(ghost.className, 'ghost', 'scared-ghost')
                    ghost.currentIndex = ghost.startIndex
                    score += 100
                    squares[ghost.currentIndex].classList.add(ghost.className, 'ghost')
                }
                }
            }, ghost.speed)

    }

    function checkGameOver() {
        console.log(squares[pacmanCurrentIndex].classList.contains('scared-ghost'))
        console.log(squares[pacmanCurrentIndex].classList.contains('ghost'))
        if (squares[pacmanCurrentIndex].classList.contains('ghost') && !squares[pacmanCurrentIndex].classList.contains('scared-ghost')) {
            ghosts.forEach(ghost => clearInterval(ghost.timerId))
            document.removeEventListener('keyup', movePacman)
            setTimeout(function () {
                alert('Game Over !')
            }, 500)

        }
    }
})


