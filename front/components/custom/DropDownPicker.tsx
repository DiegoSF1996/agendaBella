import React, { useState } from 'react';
import { Text } from 'react-native';
import DropDownPicker, {
  DropDownPickerProps,
} from 'react-native-dropdown-picker';

export interface DropdownItem {
  label: string;
  value: string | number;
  disabled?: boolean;
}

interface CustomDropdownProps {
  items: DropdownItem[];
  value: string | number | null;
  setValue: React.Dispatch<React.SetStateAction<string | number | null>>;
  placeholder?: string;
  searchable?: boolean;
  style?: DropDownPickerProps<any>['style'];
}

export default function CustomDropdown({
  items,
  value,
  setValue,
  placeholder = 'Selecione uma opção',
  searchable = true,
  style = {},
}: CustomDropdownProps) {
  const [open, setOpen] = useState(false);
  const [localItems, setLocalItems] = useState(items);

  return (
    <DropDownPicker
      open={open}
      value={value}
      items={localItems}
      setOpen={setOpen}
      setValue={setValue}
      setItems={setLocalItems}
      searchable={searchable}
      searchPlaceholder="Buscar..."
      placeholder={placeholder}
      listMode="MODAL"
      style={[{ borderColor: 'gray', marginBottom: open ? 150 : 10 }, style]}
      dropDownContainerStyle={{ borderColor: 'gray' }}
      ListEmptyComponent={() => (
        <Text style={{ padding: 10, color: 'gray' }}>
          Nenhum resultado encontrado
        </Text>
      )}
    />
  );
}
