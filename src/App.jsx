import React from 'react'
import { BrowserRouter, Routes, Route } from 'react-router-dom'

import ProductList from './components/ProductList'
import Footer from './components/Footer'
import ProductCreate from './components/ProductCreate'
import './sass/App.scss'

function App() {
  return (
    <div className='App'>
      <main className='main'>
        <BrowserRouter>
          <Routes>
            <Route index element={<ProductList />} />
            <Route path='add-product' element={<ProductCreate />} />
            <Route path='*' element={<Footer />}>
              sdf
            </Route>
          </Routes>
        </BrowserRouter>
      </main>

      <Footer />
    </div>
  )
}

export default App
