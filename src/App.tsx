import { useState } from 'react'
import './App.css'

function App() {
  const [count, setCount] = useState(0)

  return (
    <div className="app">
      <header className="header">
        <h1>Bem-vindo</h1>
        <p>Sua aplicação está funcionando!</p>
      </header>

      <main className="main">
        <div className="card">
          <button onClick={() => setCount((count) => count + 1)}>
            Contador: {count}
          </button>
        </div>
      </main>
    </div>
  )
}

export default App
