import { useState } from 'react'
import '../sass/ProductItem.scss'

export default function ProductItem({ data, handleProductChange }) {
  const [isChecked, setIsChecked] = useState(false)

  const handleCheck = () => {
    setIsChecked(!isChecked)
    handleProductChange(data.sku)
  }

  return (
    <div className='product-item'>
      <input
        type='checkbox'
        className='delete-checkbox product-item__checkbox'
        checked={isChecked}
        onChange={handleCheck}
      />
      <div className='product-item__sku'>{data.sku}</div>
      <div className='product-item__name'>{data.name}</div>
      <div className='product-item__price'>{data.price} $</div>
      <div className='product-item__attribute'>
        <span>
          {data.type === 'dvd' && 'Size: '}
          {data.type === 'book' && 'Weight: '}
          {data.type === 'furniture' && 'Dimension: '}
        </span>
        {data.attribute}
      </div>
    </div>
  )
}
