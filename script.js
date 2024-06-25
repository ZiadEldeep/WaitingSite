document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('networkCanvas');
    const ctx = canvas.getContext('2d');
    const nodes = [];
    const maxDistance = 150;
    const numNodes = 100;

    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    class Node {
        constructor(x, y) {
            this.x = x;
            this.y = y;
            this.radius = 3;
            this.color = 'rgba(128, 128, 128, 0.8)';
            this.velocityX = (Math.random() - 0.5) * 2;
            this.velocityY = (Math.random() - 0.5) * 2;
        }

        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fillStyle = this.color;
            ctx.fill();
            ctx.closePath();
        }

        update() {
            this.x += this.velocityX;
            this.y += this.velocityY;

            if (this.x < 0 || this.x > canvas.width) this.velocityX *= -1;
            if (this.y < 0 || this.y > canvas.height) this.velocityY *= -1;
        }
    }

    function connectNodes() {
        for (let i = 0; i < nodes.length; i++) {
            for (let j = i + 1; j < nodes.length; j++) {
                const distance = Math.hypot(nodes[i].x - nodes[j].x, nodes[i].y - nodes[j].y);
                if (distance < maxDistance) {
                    ctx.beginPath();
                    ctx.moveTo(nodes[i].x, nodes[i].y);
                    ctx.lineTo(nodes[j].x, nodes[j].y);
                    ctx.strokeStyle = `rgba(128, 128, 128, ${1 - distance / maxDistance})`;
                    ctx.stroke();
                    ctx.closePath();
                }
            }
        }
    }

    function createInitialNodes() {
        for (let i = 0; i < numNodes; i++) {
            const x = Math.random() * canvas.width;
            const y = Math.random() * canvas.height;
            nodes.push(new Node(x, y));
        }
    }

    function findNearestNodes(x, y, count) {
        const distances = nodes.map(node => ({
            node,
            distance: Math.hypot(node.x - x, node.y - y)
        }));
        distances.sort((a, b) => a.distance - b.distance);
        return distances.slice(0, count).map(d => d.node);
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        nodes.forEach(node => {
            node.update();
            node.draw();
        });
        connectNodes();
        requestAnimationFrame(animate);
    }

    canvas.addEventListener('click', (e) => {
        const nearestNodes = findNearestNodes(e.clientX, e.clientY, 2);
        nearestNodes.forEach(node => {
            nodes.push(new Node(node.x + (Math.random() - 0.5) * 20, node.y + (Math.random() - 0.5) * 20));
        });
    });

    canvas.addEventListener('mousemove', (e) => {
        const nearestNodes = findNearestNodes(e.clientX, e.clientY, 2);
        nearestNodes.forEach(node => {
            ctx.beginPath();
            ctx.moveTo(e.clientX, e.clientY);
            ctx.lineTo(node.x, node.y);
            ctx.strokeStyle = 'rgba(128, 128, 128, 0.6)';
            ctx.stroke();
            ctx.closePath();
        });
    });

    createInitialNodes();
    animate();
});
