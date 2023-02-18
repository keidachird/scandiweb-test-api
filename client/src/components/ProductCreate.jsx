import axios from 'axios'
import { useState } from 'react'
import { Link, useNavigate } from 'react-router-dom'

import './ProductCreate.scss'

export default function ProductCreate() {
  const [productData, setProductData] = useState({
    sku: '',
    name: '',
    price: '',
    type: 'default',
    size: '',
    weight: '',
    height: '',
    width: '',
    length: '',
  })
  const [validationError, setValidationError] = useState('')
  const navigate = useNavigate()

  const handleTypeChange = e => {
    setProductData({
      sku: productData.sku,
      name: productData.name,
      price: productData.price,
      type: e.target.value,
      size: '',
      weight: '',
      height: '',
      width: '',
      length: '',
    })
  }

  const handleSubmit = async e => {
    e.preventDefault()

    validateData()

    await axios.post(
      'http://localhost/add-product',
      JSON.stringify(productData)
    )

    setProductData({
      sku: '',
      name: '',
      price: '',
      type: 'default',
    })

    navigate('/')
  }

  const validateData = () => {
    for (let [key, value] of Object.entries(productData)) {
      console.log(key, value)
    }
  }

  return (
    <div className='product-create container'>
      {/* Header */}
      <header className='product-list__header'>
        <h2 className='product-list__title'>Product Add</h2>

        <button type='submit' form='product_form' className='btn btn--add'>
          Save
        </button>

        <Link to='/' className='btn btn--cancel'>
          Cancel
        </Link>
      </header>

      {/* Form */}
      <form
        action=''
        id='product_form'
        className='product-form'
        onSubmit={e => handleSubmit(e)}
      >
        {/* Sku input */}
        <div className='product-form__item'>
          <label htmlFor='sku' className='product-form__label'>
            SKU
          </label>
          <input
            type='text'
            id='sku'
            className='product-form__input'
            value={productData.sku}
            onChange={e =>
              setProductData({ ...productData, sku: e.target.value })
            }
          />
        </div>

        {/* Name input */}
        <div className='product-form__item'>
          <label htmlFor='name' className='product-form__label'>
            Name
          </label>
          <input
            type='text'
            id='name'
            className='product-form__input'
            value={productData.name}
            onChange={e =>
              setProductData({ ...productData, name: e.target.value })
            }
          />
        </div>

        {/* Price input */}
        <div className='product-form__item'>
          <label htmlFor='price' className='product-form__label'>
            Price ($)
          </label>
          <input
            type='number'
            id='price'
            className='product-form__input'
            value={productData.price}
            onChange={e =>
              setProductData({ ...productData, price: e.target.value })
            }
          />
        </div>

        <p className='product-form__text'>
          {productData.type === 'default' && 'Please, select product type'}
          {productData.type === 'dvd' && 'Please, provide size'}
          {productData.type === 'bokk' && 'Please, provide weight'}
          {productData.type === 'furniture' && 'Please, provide dimensions'}
        </p>

        {/* Type switcher field */}
        <div className='product-form__item'>
          <label htmlFor='productType' className='product-form__label'>
            Type Switcher
          </label>
          <select
            name='type'
            id='productType'
            className='product-form__select'
            value={productData.type}
            onChange={e => handleTypeChange(e)}
          >
            <option value='default'></option>
            <option value='dvd'>DVD</option>
            <option value='book'>Book</option>
            <option value='furniture'>Furniture</option>
          </select>
        </div>

        {/* Input for dvd size type */}
        {productData.type === 'dvd' && (
          <div className='product-form__item'>
            <label htmlFor='size' className='product-form__label'>
              Size (MB)
            </label>
            <input
              type='number'
              id='size'
              className='product-form__input'
              value={productData.size || ''}
              onChange={e =>
                setProductData({ ...productData, size: e.target.value })
              }
            />
          </div>
        )}

        {/* Input for book weight */}
        {productData.type === 'book' && (
          <div className='product-form__item'>
            <label htmlFor='book' className='product-form__label'>
              Weight (KG)
            </label>
            <input
              type='number'
              id='weigth'
              className='product-form__input'
              value={productData.weight || ''}
              onChange={e =>
                setProductData({ ...productData, weight: e.target.value })
              }
            />
          </div>
        )}

        {/* Inputs for furniture dimensions */}
        {productData.type === 'furniture' && (
          <>
            <div className='product-form__item'>
              <label htmlFor='height' className='product-form__label'>
                Height (CM)
              </label>
              <input
                type='number'
                id='height'
                className='product-form__input'
                value={productData.height || ''}
                onChange={e =>
                  setProductData({ ...productData, height: e.target.value })
                }
              />
            </div>

            <div className='product-form__item'>
              <label htmlFor='width' className='product-form__label'>
                Width (CM)
              </label>
              <input
                type='number'
                id='width'
                className='product-form__input'
                value={productData.width || ''}
                onChange={e =>
                  setProductData({ ...productData, width: e.target.value })
                }
              />
            </div>

            <div className='product-form__item'>
              <label htmlFor='length' className='product-form__label'>
                Length (CM)
              </label>
              <input
                type='number'
                id='length'
                className='product-form__input'
                value={productData.length || ''}
                onChange={e =>
                  setProductData({ ...productData, length: e.target.value })
                }
              />
            </div>
          </>
        )}
      </form>
    </div>
  )
}
